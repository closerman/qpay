<?php

namespace App\Console\Commands;

use App\Models\Agent;
use App\Models\Order;
use Illuminate\Console\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;

class CollectAgent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collect:agent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'collect:agent';


    protected $client = null;
    protected $base_uri = 'http://59.151.121.119:8082';

    protected $userName = '';
    protected $password = '';

    private $code_img_file = '';
    private $cookie_file = '';
    private $login_try_times = 1; // 尝试登陆次数
    private $login_haved_try_times = 0; //已经尝试的次数
    private $isTryLogin = false;
    private $kaptcha = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->userName = env('QPAY_USERNAME', '');
        $this->password = env('QPAY_PASSWORD', '');
        if(!$this->userName || !$this->password) {
            $this->info('请在环境文件里设置用户名，和密码');
            exit;
        }
        $jar = new \GuzzleHttp\Cookie\CookieJar;
        $this->code_img_file = storage_path('app/cache').'/kaptcha_img.jpg';
        $this->cookie_file = storage_path('app/cache').'/cookie_file.txt';
        $fileCookieJar = new FileCookieJar($this->cookie_file, true);
        $this->client = new Client(['base_uri' => $this->base_uri, 'timeout' =>90, 'cookies' => $fileCookieJar, 'allow_redirects' => false]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("agent:代理");
        $this->info("order1:直属交易订单");
        $this->info("order2:代理交易订单");
        $this->info("downloadImg:下载验证吗");
        $action = $this->ask('action');

        $this->kaptcha = 'aa';
        switch($action) {
            case 'agent':
                $this->getSalesMan();
                break;
            case 'order1':
                $this->order();
                break;
            case 'order2':
                $this->order(1, false);
                break;


        }


    }



    /**
     * 对图片进行base64编码
     * @param $image_file
     * @return string
     */
    private function base64EncodeImage ($image_file)
    {
        $fp  = fopen($image_file, 'rb', 0);
        $base64_image=base64_encode(fread($fp,filesize($image_file)));
        fclose($fp);
        return urlencode($base64_image);
    }

    /**
     * 识别验证码
     * @return bool｜string
     */
    private function  check_code_api() {
        return $this->kaptcha;
        $this->line('开始识别验证码');
        $host = "https://ali-checkcode2.showapi.com";
        $path = "/checkcode";
        $appcode = "87e681c0434f4f4d8b1bd30afa5dac76";
        $base64_img = $this->base64EncodeImage($this->code_img_file);
        $body = "convert_to_jpg=0&img_base64=" . $base64_img . "&typeId=34";
        $headers =  ['Authorization'=>"APPCODE " . $appcode, 'Content-Type'=>'application/x-www-form-urlencoded; charset=UTF-8'];
        $client = new Client(['base_uri' => $host, 'timeout' => 110]);
        $response = $client->post($path, ['body' => $body, 'headers' => $headers]);

        $result_aso = json_decode($response->getBody());

        if($result_aso && $result_aso->showapi_res_error == '') {
            return $verify_code = $result_aso->showapi_res_body->Result;
        } else {
            return false;
        }
    }

    /**
     * 验证注册码是否正确
     * @param $verify_code
     * @return bool
     */
    private function test_verify_code($verify_code) {
        $this->line('开始检测验证码是否正确'. $verify_code);

        $result = $this->client->post('/mss/validateKaptchaImage.jhtml', ['form_params'=>['kaptcha' => $verify_code]]);
        $result_aso = json_decode($result->getBody());
        $this->info((string)$result->getBody());
        if($result_aso->code == '00') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 下载验证码图片
     */
    private function download_kaptcha_img() {
        $this->line('正在下载验证码图片...');
        $img = $this->client->get('/mss/getKaptchaImage.jhtml')->getBody();
        $fp = fopen($this->code_img_file, "w+");
        fwrite($fp, $img);
        fclose($fp);
    }

    /**
     * 进行登录
     * @param $verify_code
     */
    private function doLogin($verify_code) {
        $result = $this->client->post('/mss/main.jhtml', ['form_params' => ['agentShortName'=>$this->userName, 'password'=>$this->password, 'checkCode'=>$verify_code]]);
        if(substr_count((string)$result->getBody(),"退出")){
            $this->login_haved_try_times = 0;
            $this->info('登录成功');
            return true;
        }

        $this->line('登录失败');
        return false;
    }

    /**
     * 进行模拟登录
     */
    public function login() {
        if($this->isTryLogin) {
            return false;
        }
        $this->isTryLogin = true;

        $success_get_verify_code = false;
        do{
            //下载验证码
            $this->download_kaptcha_img();

            //识别验证码
            if($verify_code = $this->check_code_api()) {
                $this->info("验证码成功取出：$verify_code");
                //判断验证码是否正确。
                //$success_get_verify_code = $this->test_verify_code($verify_code);
                return $this->doLogin($verify_code);
            }
            $this->login_haved_try_times ++;
            $this->line('已经尝试'.$this->login_haved_try_times.'次');
        }while(!$success_get_verify_code && $this->login_haved_try_times  <= $this->login_try_times);


        if($success_get_verify_code) {
            $this->line('正在准备模拟登录...');
            return $this->doLogin($verify_code);
        } else {
            $this->info('验证码识别失败次数大于'.$this->login_try_times.'次,登陆失败');
            return false;
        }
    }

    /**
     * 采集我的交易
     */
    /**
     * @param int $currentPageNum
     * @param bool $isSub 为true时候采集的是直属会员订单数据，为false时，采集的是下级代理的数据
     */
    public function order($currentPageNum = 1, $isSub = true) {
        $date = date("Y-m-d");
        $uri = '/mss/order/pos_order_list.jhtml?currentPageNum=' . $currentPageNum;
        $postData = [
            'startTime'=>$date,
            'endTime'=>$date,
            'cardNo'=>'',
            'merchantName'=>'',
            'phone'=>'',
            'orderNo'=>'',
            'tradeType'=>'',
            'tradeStatus'=>'',
            'settleMode'=>'',
            'machineTerminalId'=>'',
            'salesmanPhone'=>'',
            'salesmanName'=>'',

            'serviceScope'=>'',
            'paymentFlag'=>'',
            'cardType'=>'',
            'merchantProductType'=>'',
            'agentId'=>''
            ];
        if(!$isSub) {
            $postData['isSub'] = 'false';
            /*
             * startTime:2017-10-13
endTime:2017-10-15
cardNo:
merchantName:
phone:
orderNo:
tradeType:
tradeStatus:
settleMode:
machineTerminalId:
salesmanPhone:
salesmanName:


isSub:false
serviceScope:
paymentFlag:
cardType:
merchantProductType:

agentName:
            agentId:
             *
             * */
        }
        $result = $this->client->post($uri, ['form_params'=>$postData]);
        $result = (string)$result->getBody();
        if(strpos($result,  'The URL has moved') === 0) {
            $this->info('登录超时，尝试重新登录');
            if($this->login()) {
                $this->order($currentPageNum, $isSub);
            }
        }

        $array_asso = \GuzzleHttp\json_decode($result, true);

        $this->info('开始采集，共有'.$array_asso['pages']);
        if($array_asso['code'] == '00') {
            foreach($array_asso['list'] as $item) {
//
                $this->line("当前是第{$array_asso['pageNumber']}页");
                Order::firstOrCreate(['id'=>$item['id']], $item);
            }

            if($currentPageNum < $array_asso['pages']) {
                $this->order($currentPageNum+1);
            }
        }

    }

    public function getSalesMan()
    {
        $url = '/mss/salesman/get_agent_salesman_list.jhtml';
        $postData = [
            'startTime'=>'',
            'endTime'=>'2017-10-09',
            'status'=>'30A,10A,30B,20C,20B,30C,20A',
            'currentPageNum'=>1,
            'currentPageSize'=>100,
        ];
        $result = (string)$this->client->post($url, ['form_params'=>$postData])->getBody();

        if(strpos($result,  'The URL has moved') === 0) {
            $this->info('登录超时，尝试重新登录');
            if($this->login()) {
                $this->getSalesMan();
            }
        } else {

            $array_asso = \GuzzleHttp\json_decode($result, true);

            foreach($array_asso['list'] as $agent) {
                $_agent = [
//                    'id'=> $agent['id'],
                    'salesman_no'=>$agent['salesmanNo'],
                    'status_code'=>$agent['statusCode'],
                    'salesman_status'=>$agent['salesmanStatus'],
                    'email'=>$agent['email'],
                    'mobile'=>$agent['phone'],
                    'created_at'=>$agent['createTime'],
                    'password' => app('hash')->make('123456'),
                ];
               // $this->line($_agent);
                Agent::firstOrCreate(['name'=>$agent['name']],$_agent);
            }
            $this->line('采集完成, ＝》'.$array_asso['count']);

        }


    }


}
