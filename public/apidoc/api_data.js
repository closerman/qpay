define({ "api": [
  {
    "type": "get",
    "url": "/agents",
    "title": "代理列表(agent list)",
    "description": "<p>代理列表</p>",
    "group": "Agent",
    "permission": [
      {
        "name": "JWT"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'{\"mobile__like__\":\"1867%\"}'"
            ],
            "optional": true,
            "field": "condition",
            "description": "<p>可用的操作符号：'<strong>like</strong>, <strong>lg</strong>,<strong>lt</strong>,<strong>gte</strong>,<strong>lte</strong>,<strong>ne</strong>,<strong>in</strong>,<strong>nin</strong>,<strong>between</strong>'</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "'limit'"
            ],
            "optional": true,
            "field": "limit",
            "description": "<p>每页显示多少条</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "'curpage'"
            ],
            "optional": true,
            "field": "curpage",
            "description": "<p>当前页</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "success-response:",
          "content": "HTTP/1.1 200 ok\n{\n    \"data\": [\n    {\n    \"id\": 1,\n    \"salesman_no\": \"306063\",\n    \"name\": \"彭自由\",\n    \"mobile\": \"13***538\",\n    \"email\": \"134**8538@qq.com\",\n    \"id_card_number\": null,\n    \"id_card_pic_up\": null,\n    \"id_card_pic_down\": null,\n    \"id_card_pic_with_people\": null,\n    \"province\": null,\n    \"city\": null,\n    \"district\": null,\n    \"address\": null,\n    \"active\": \"0\",\n    \"audit\": \"0\",\n    \"status_code\": \"20A\",\n    \"salesman_status\": \"10A\",\n    \"created_at\": null,\n    \"updated_at\": null\n    },\n    {\n    \"id\": 2,\n    \"salesman_no\": \"294023\",\n    \"name\": \"黄志楼\",\n    \"mobile\": \"137***2723\",\n    \"email\": \"137**2723@qq.com\",\n    \"id_card_number\": null,\n    \"id_card_pic_up\": null,\n    \"id_card_pic_down\": null,\n    \"id_card_pic_with_people\": null,\n    \"province\": null,\n    \"city\": null,\n    \"district\": null,\n    \"address\": null,\n    \"active\": \"0\",\n    \"audit\": \"0\",\n    \"status_code\": \"20A\",\n    \"salesman_status\": \"10A\",\n    \"created_at\": null,\n    \"updated_at\": null\n    },\n    ],\n    \"meta\": {\n    \"pagination\": {\n    \"total\": 4,\n    \"count\": 4,\n    \"per_page\": 15,\n    \"current_page\": 1,\n    \"total_pages\": 1,\n    \"links\": []\n    }\n    }\n    }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/AgentController.php",
    "groupTitle": "Agent",
    "name": "GetAgents"
  },
  {
    "type": "delete",
    "url": "/authorizations/current",
    "title": "删除当前token (delete current token)",
    "description": "<p>删除当前token (delete current token)</p>",
    "group": "Auth",
    "permission": [
      {
        "name": "jwt"
      }
    ],
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 No Content",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/AuthController.php",
    "groupTitle": "Auth",
    "name": "DeleteAuthorizationsCurrent"
  },
  {
    "type": "post",
    "url": "/authorizations",
    "title": "创建一个token (create a token)",
    "description": "<p>创建一个token (create a token).　*</p>",
    "group": "Auth",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Email",
            "optional": false,
            "field": "email",
            "description": "<p>邮箱</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "认证方式:",
          "content": "　　　有两种认证方式，可以选择其中一个\n    \"１，header头认证　  'Authorization': 'Bearer　获得的token'\"\n    \"２， url认证　　　　'token': '获得的token' \"",
          "type": "json"
        }
      ]
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 Created\n{\n    \"data\": {\n        \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbHVtZW4tYXBpLWRlbW8uZGV1L2FwaS9hdXRob3JpemF0aW9ucyIsImlhdCI6MTQ4Mzk3NTY5MywiZXhwIjoxNDg5MTU5NjkzLCJuYmYiOjE0ODM5NzU2OTMsImp0aSI6ImViNzAwZDM1MGIxNzM5Y2E5ZjhhNDk4NGMzODcxMWZjIiwic3ViIjo1M30.hdny6T031vVmyWlmnd2aUr4IVM9rm2Wchxg5RX_SDpM\",\n        \"expired_at\": \"2017-03-10 15:28:13\",\n        \"refresh_expired_at\": \"2017-01-23 15:28:13\"\n    }\n}     *",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 401\n{\n  \"error\": \"用户面密码错误\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/AuthController.php",
    "groupTitle": "Auth",
    "name": "PostAuthorizations"
  },
  {
    "type": "put",
    "url": "/authorizations/current",
    "title": "刷新token(refresh token)",
    "description": "<p>刷新token(refresh token)</p>",
    "group": "Auth",
    "permission": [
      {
        "name": "JWT"
      }
    ],
    "version": "0.1.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户旧的jwt-token, value以Bearer开头</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n  \"Authorization\": \"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL21vYmlsZS5kZWZhcmEuY29tXC9hdXRoXC90b2tlbiIsImlhdCI6IjE0NDU0MjY0MTAiLCJleHAiOiIxNDQ1NjQyNDIxIiwibmJmIjoiMTQ0NTQyNjQyMSIsImp0aSI6Ijk3OTRjMTljYTk1NTdkNDQyYzBiMzk0ZjI2N2QzMTMxIn0.9UPMTxo3_PudxTWldsf4ag0PHq1rK8yO9e5vqdwRZLY\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbHVtZW4tYXBpLWRlbW8uZGV1L2FwaS9hdXRob3JpemF0aW9ucyIsImlhdCI6MTQ4Mzk3NTY5MywiZXhwIjoxNDg5MTU5NjkzLCJuYmYiOjE0ODM5NzU2OTMsImp0aSI6ImViNzAwZDM1MGIxNzM5Y2E5ZjhhNDk4NGMzODcxMWZjIiwic3ViIjo1M30.hdny6T031vVmyWlmnd2aUr4IVM9rm2Wchxg5RX_SDpM\",\n        \"expired_at\": \"2017-03-10 15:28:13\",\n        \"refresh_expired_at\": \"2017-01-23 15:28:13\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/AuthController.php",
    "groupTitle": "Auth",
    "name": "PutAuthorizationsCurrent"
  },
  {
    "type": "get",
    "url": "/orders",
    "title": "订单列表(orders list)",
    "description": "<p>订单列表</p>",
    "group": "Order",
    "permission": [
      {
        "name": "JWT"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'{\"mobile__like__\":\"1867%\"}'"
            ],
            "optional": true,
            "field": "condition",
            "description": "<p>可用的操作符号：'<strong>like</strong>, <strong>lg</strong>,<strong>lt</strong>,<strong>gte</strong>,<strong>lte</strong>,<strong>ne</strong>,<strong>in</strong>,<strong>nin</strong>,<strong>between</strong>'.记得condition要用encodeURIComponent编码，否则一些特殊字符导致查询到的数据不符合预期</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "'limit'"
            ],
            "optional": true,
            "field": "limit",
            "description": "<p>每页显示多少条</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "'curpage'"
            ],
            "optional": true,
            "field": "curpage",
            "description": "<p>当前页</p>"
          },
          {
            "group": "Parameter",
            "type": "Json",
            "allowedValues": [
              "'[\"trxAmount\"]'"
            ],
            "optional": false,
            "field": "sum",
            "description": "<p>要求和的字段数组</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "success-response:",
          "content": "HTTP/1.1 200 ok\n{\n    {\n    \"data\": [\n        {\n            \"id\": 3,\n            \"agentName\": \"D深圳市廖闹中支付有\",\n            \"cardNo\": \"6226388008805032\",\n            \"cardType\": \"银联贷记卡\",\n            \"depict\": null,\n            \"failureReason\": \"交易成功\",\n            \"fee\": null,\n            \"addFee\": null,\n            \"machineTerminalId\": null,\n            \"merchantName\": \"深圳市罗志敏乐购百货\",\n            \"merchantNo\": null,\n            \"merchantProductType\": \"Qpos\",\n            \"orderCount\": null,\n            \"paymentFlag\": \"pos刷卡\",\n            \"paymentNo\": \"2017100922170422571\",\n            \"phone\": \"13699750558\",\n            \"rateCode\": null,\n            \"salesmanName\": \"廖闹忠\",\n            \"salesmanPhone\": \"158***52389\",\n            \"settleMode\": \"T+0\",\n            \"status\": \"交易成功\",\n            \"sumFee\": null,\n            \"trxAmount\": \"8951\",\n            \"trxAmountCount\": null,\n            \"trxSource\": null,\n            \"trxTime\": \"2017-10-09 22:48:34\",\n            \"trxType\": \"POS消费\",\n            \"created_at\": null,\n            \"updated_at\": null\n        },\n        {\n            \"id\": 0,\n            \"agentName\": \"D深圳市廖闹中支付有\",\n            \"cardNo\": \"4864945032214119\",\n            \"cardType\": \"银联贷记卡\",\n            \"depict\": null,\n            \"failureReason\": \"交易成功\",\n            \"fee\": null,\n            \"addFee\": null,\n            \"machineTerminalId\": null,\n            \"merchantName\": \"深圳市罗志敏乐购百货\",\n            \"merchantNo\": null,\n            \"merchantProductType\": \"Qpos\",\n            \"orderCount\": null,\n            \"paymentFlag\": \"pos刷卡\",\n            \"paymentNo\": \"2017101220171300695\",\n            \"phone\": \"136***50558\",\n            \"rateCode\": null,\n            \"salesmanName\": \"廖闹忠\",\n            \"salesmanPhone\": \"158***52389\",\n            \"settleMode\": \"T+0\",\n            \"status\": \"交易成功\",\n            \"sumFee\": null,\n            \"trxAmount\": \"6879\",\n            \"trxAmountCount\": null,\n            \"trxSource\": null,\n            \"trxTime\": \"2017-10-12 20:32:23\",\n            \"trxType\": \"POS消费\",\n            \"created_at\": null,\n            \"updated_at\": null\n        }\n    ],\n    \"meta\": {\n        \"sum\": {\n            \"trxAmount\": \"468626\"\n        },\n        \"pagination\": {\n            \"total\": 23,\n            \"count\": 2,\n            \"per_page\": 2,\n            \"current_page\": 1,\n            \"total_pages\": 12,\n            \"links\": {\n            \"next\": \"http://qpay.net/api/orders?=2\"\n         }\n    }\n    }\n    }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/OrderController.php",
    "groupTitle": "Order",
    "name": "GetOrders"
  },
  {
    "type": "delete",
    "url": "/documents/{id}",
    "title": "删除文案(delete document)",
    "description": "<p>删除文案(delete document)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "jwt"
      }
    ],
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 NO CONTENT",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/DocumentController.php",
    "groupTitle": "Spread",
    "name": "DeleteDocumentsId"
  },
  {
    "type": "delete",
    "url": "/images/{id}",
    "title": "删除图片(delete images)",
    "description": "<p>删除图片(delete images)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "jwt"
      }
    ],
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 NO CONTENT",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/ImageController.php",
    "groupTitle": "Spread",
    "name": "DeleteImagesId"
  },
  {
    "type": "delete",
    "url": "/posts/{id}",
    "title": "删除文章(delete post)",
    "description": "<p>删除文章(delete post)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "jwt"
      }
    ],
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 NO CONTENT",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/PostController.php",
    "groupTitle": "Spread",
    "name": "DeletePostsId"
  },
  {
    "type": "get",
    "url": "/documents",
    "title": "文案列表(documents list)",
    "description": "<p>文案列表(documents list)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'comments:limit(x)'",
              "'user'"
            ],
            "optional": true,
            "field": "include",
            "description": "<p>include</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "'limit'"
            ],
            "optional": true,
            "field": "limit",
            "description": "<p>每页显示多少条</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "'curpage'"
            ],
            "optional": true,
            "field": "curpage",
            "description": "<p>当前页</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": [\n    {\n      \"id\": 1,\n      \"user_id\": 3,\n      \"title\": \"foo\",\n      \"content\": \"\",\n      \"created_at\": \"2016-03-30 15:36:30\",     *\n      \"comments\": {\n        \"data\": [],\n        \"meta\": {\n          \"total\": 0\n        }\n      }\n    }\n  ],\n  \"meta\": {\n    \"pagination\": {\n      \"total\": 2,\n      \"count\": 2,\n      \"per_page\": 15,\n      \"current_page\": 1,\n      \"total_pages\": 1,\n      \"links\": []\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/DocumentController.php",
    "groupTitle": "Spread",
    "name": "GetDocuments"
  },
  {
    "type": "get",
    "url": "/documents/{id}",
    "title": "文案详情(document detail)",
    "description": "<p>文案详情(document detail)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'comments:limit(x)'",
              "'user'"
            ],
            "optional": true,
            "field": "include",
            "description": "<p>include</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "  HTTP/1.1 200 OK\n    {\n     \"data\": {\n         \"id\": 1,\n         \"user_id\": 1,\n         \"title\": \"文案１\",\n          \"content\": \"这是个文案测试\",\n         \"created_at\": \"2017-10-14 13:51:53\",\n         \"updated_at\": \"2017-10-14 13:51:53\",\n         \"images\": {\n             \"data\": [\n                 {\n                      \"id\": 5,\n                     \"type\": \"document\",\n                     \"parent_id\": 1,\n                     \"user_id\": 1,\n                     \"url\": \"2017_10_14/a6f5cc7bf1f7dd930be126e77eb5339f5.png\",\n                     \"created_at\": \"2017-10-14 13:53:49\",\n                     \"updated_at\": \"2017-10-14 13:53:49\"\n                 }\n             ],\n     \"meta\": {\n     \"limit\": 10,\n     \"count\": 1,\n     \"total\": 1\n     }\n  }\n}\n    }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/DocumentController.php",
    "groupTitle": "Spread",
    "name": "GetDocumentsId"
  },
  {
    "type": "get",
    "url": "/images/{type}/{parent_id}",
    "title": "图片列表(post images list)",
    "description": "<p>图片列表(post images list)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'user'",
              "'posts'",
              "'document'"
            ],
            "optional": false,
            "field": "include",
            "description": "<p>include</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'post，document'"
            ],
            "optional": false,
            "field": "type",
            "description": "<p>类型</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'id'"
            ],
            "optional": false,
            "field": "id",
            "description": "<p>文章或文案id</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n\n {\n     \"data\": [\n         {\n             \"id\": 6,\n             \"type\": \"document\",\n             \"parent_id\": 1,\n             \"user_id\": 1,\n             \"url\": \"2017_10_14/6d88267b3fee2bda19cbd1b7fa4d35805.png\",\n             \"created_at\": \"2017-10-14 15:29:51\",\n             \"updated_at\": \"2017-10-14 15:29:51\",\n             \"document\": {\n                 \"data\": {\n                     \"id\": 1,\n                     \"user_id\": 1,\n                     \"title\": \"文案１\",\n                     \"content\": \"这是个文案测试\",\n                     \"created_at\": \"2017-10-14 13:51:53\",\n                     \"updated_at\": \"2017-10-14 13:51:53\"\n                 }\n             }\n         }\n     ],\n     \"meta\": {\n         \"pagination\": {\n             \"total\": 1,\n             \"count\": 1,\n             \"per_page\": 15,\n             \"current_page\": 1,\n             \"total_pages\": 1,\n             \"links\": []\n         }\n     }\n }\n\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/ImageController.php",
    "groupTitle": "Spread",
    "name": "GetImagesTypeParent_id"
  },
  {
    "type": "get",
    "url": "/posts",
    "title": "文章列表(post list)",
    "description": "<p>文章列表(post list)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'comments:limit(x)'",
              "'user'"
            ],
            "optional": true,
            "field": "include",
            "description": "<p>include</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "'limit'"
            ],
            "optional": true,
            "field": "limit",
            "description": "<p>每页显示多少条</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "'curpage'"
            ],
            "optional": true,
            "field": "curpage",
            "description": "<p>当前页</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": [\n    {\n      \"id\": 1,\n      \"user_id\": 3,\n      \"title\": \"foo\",\n      \"content\": \"\",\n      \"created_at\": \"2016-03-30 15:36:30\",\n      \"user\": {\n        \"data\": {\n          \"id\": 3,\n          \"email\": \"foo@bar.com1\",\n          \"name\": \"\",\n          \"avatar\": \"\",\n          \"created_at\": \"2016-03-30 15:34:01\",\n          \"updated_at\": \"2016-03-30 15:34:01\",\n          \"deleted_at\": null\n        }\n      },\n      \"comments\": {\n        \"data\": [],\n        \"meta\": {\n          \"total\": 0\n        }\n      }\n    }\n  ],\n  \"meta\": {\n    \"pagination\": {\n      \"total\": 2,\n      \"count\": 2,\n      \"per_page\": 15,\n      \"current_page\": 1,\n      \"total_pages\": 1,\n      \"links\": []\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/PostController.php",
    "groupTitle": "Spread",
    "name": "GetPosts"
  },
  {
    "type": "get",
    "url": "/posts/{id}",
    "title": "文章详情(post detail)",
    "description": "<p>文章详情(post detail)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'comments'",
              "'user'"
            ],
            "optional": true,
            "field": "include",
            "description": "<p>include</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"id\": 1,\n    \"user_id\": 3,\n    \"title\": \"foo\",\n    \"content\": \"\",\n    \"created_at\": \"2016-03-30 15:36:30\",\n    \"user\": {\n      \"data\": {\n        \"id\": 3,\n        \"email\": \"foo@bar.com1\",\n        \"name\": \"\",\n        \"avatar\": \"\",\n        \"created_at\": \"2016-03-30 15:34:01\",\n        \"updated_at\": \"2016-03-30 15:34:01\",\n        \"deleted_at\": null\n      }\n    },\n    \"comments\": {\n      \"data\": [\n        {\n          \"id\": 1,\n          \"post_id\": 1,\n          \"user_id\": 1,\n          \"reply_user_id\": 0,\n          \"content\": \"foobar\",\n          \"created_at\": \"2016-04-06 14:51:34\"\n        }\n      ],\n      \"meta\": {\n        \"total\": 1\n      }\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/PostController.php",
    "groupTitle": "Spread",
    "name": "GetPostsId"
  },
  {
    "type": "get",
    "url": "/user/documents",
    "title": "文案列表(documents list)",
    "description": "<p>文案列表(documents list)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'images:limit(x)'"
            ],
            "optional": true,
            "field": "include",
            "description": "<p>include</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": [\n    {\n      \"id\": 1,\n      \"user_id\": 3,\n      \"title\": \"foo\",\n      \"content\": \"\",\n      \"created_at\": \"2016-03-30 15:36:30\",\n      \"user\": {\n        \"data\": {\n          \"id\": 3,\n          \"email\": \"foo@bar.com1\",\n          \"name\": \"\",\n          \"avatar\": \"\",\n          \"created_at\": \"2016-03-30 15:34:01\",\n          \"updated_at\": \"2016-03-30 15:34:01\",\n          \"deleted_at\": null\n        }\n      },\n      \"comments\": {\n        \"data\": [],\n        \"meta\": {\n          \"total\": 0\n        }\n      }\n    }\n  ],\n  \"meta\": {\n    \"pagination\": {\n      \"total\": 2,\n      \"count\": 2,\n      \"per_page\": 15,\n      \"current_page\": 1,\n      \"total_pages\": 1,\n      \"links\": []\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/DocumentController.php",
    "groupTitle": "Spread",
    "name": "GetUserDocuments"
  },
  {
    "type": "get",
    "url": "/user/posts",
    "title": "我的文章列表(my post list)",
    "description": "<p>我的文章列表(my post list)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'comments:limit(x)'"
            ],
            "optional": true,
            "field": "include",
            "description": "<p>include</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": [\n    {\n      \"id\": 1,\n      \"user_id\": 3,\n      \"title\": \"foo\",\n      \"content\": \"\",\n      \"created_at\": \"2016-03-30 15:36:30\",\n      \"user\": {\n        \"data\": {\n          \"id\": 3,\n          \"email\": \"foo@bar.com1\",\n          \"name\": \"\",\n          \"avatar\": \"\",\n          \"created_at\": \"2016-03-30 15:34:01\",\n          \"updated_at\": \"2016-03-30 15:34:01\",\n          \"deleted_at\": null\n        }\n      },\n      \"comments\": {\n        \"data\": [],\n        \"meta\": {\n          \"total\": 0\n        }\n      }\n    }\n  ],\n  \"meta\": {\n    \"pagination\": {\n      \"total\": 2,\n      \"count\": 2,\n      \"per_page\": 15,\n      \"current_page\": 1,\n      \"total_pages\": 1,\n      \"links\": []\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/PostController.php",
    "groupTitle": "Spread",
    "name": "GetUserPosts"
  },
  {
    "type": "post",
    "url": "/documents",
    "title": "发布文案(create document)",
    "description": "<p>发布文案(create document)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "jwt"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>post title</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>post content</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 Created",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/DocumentController.php",
    "groupTitle": "Spread",
    "name": "PostDocuments"
  },
  {
    "type": "post",
    "url": "/images/{type}/{parent_id}",
    "title": "添加图片(create image)",
    "description": "<p>添加文章图片(create image)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "jwt"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "file",
            "description": "<p>要上传的图片</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"post\"",
              "\"document\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>post是文章，document是文案</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "parent_id",
            "description": "<p>文章或文案的ID</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 Created\n{\n\"data\": {\n   \"user_id\": 1,\n   \"parent_id\": \"1\",\n   \"type\": \"post\",\n   \"url\": \"public/upload_img/2017_10_14/dfed7b0ae3e9b1d45d31e1a9c64129c45.png\",\n   \"updated_at\": \"2017-10-14 12:07:33\",\n   \"created_at\": \"2017-10-14 12:07:33\",\n   \"id\": 3\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/ImageController.php",
    "groupTitle": "Spread",
    "name": "PostImagesTypeParent_id"
  },
  {
    "type": "post",
    "url": "/posts",
    "title": "发布文章(create post)",
    "description": "<p>发布文章(create post)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "jwt"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>post title</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>post content</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 Created",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/PostController.php",
    "groupTitle": "Spread",
    "name": "PostPosts"
  },
  {
    "type": "put",
    "url": "/documents/{id}",
    "title": "修改文案(update document)",
    "description": "<p>修改文案(update document)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "jwt"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>post title</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>post content</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 NO CONTENT",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/DocumentController.php",
    "groupTitle": "Spread",
    "name": "PutDocumentsId"
  },
  {
    "type": "put",
    "url": "/posts/{id}",
    "title": "修改文章(update post)",
    "description": "<p>修改文章(update post)</p>",
    "group": "Spread",
    "permission": [
      {
        "name": "jwt"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>post title</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>post content</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 NO CONTENT",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/PostController.php",
    "groupTitle": "Spread",
    "name": "PutPostsId"
  },
  {
    "type": "get",
    "url": "/user",
    "title": "当前用户信息(current user info)",
    "description": "<p>当前用户信息(current user info)</p>",
    "group": "user",
    "permission": [
      {
        "name": "JWT"
      }
    ],
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"id\": 2,\n    \"email\": 'liyu01989@gmail.com',\n    \"name\": \"foobar\",\n    \"created_at\": \"2015-09-08 09:13:57\",\n    \"updated_at\": \"2015-09-08 09:13:57\",\n    \"deleted_at\": null\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/UserController.php",
    "groupTitle": "user",
    "name": "GetUser"
  },
  {
    "type": "get",
    "url": "/users",
    "title": "用户列表(user list)",
    "description": "<p>用户列表(user list)</p>",
    "group": "user",
    "permission": [
      {
        "name": "none"
      }
    ],
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": [\n    {\n      \"id\": 2,\n      \"email\": \"490554191@qq.com\",\n      \"name\": \"fff\",\n      \"created_at\": \"2015-11-12 10:37:14\",\n      \"updated_at\": \"2015-11-13 02:26:36\",\n      \"deleted_at\": null\n    }\n  ],\n  \"meta\": {\n    \"pagination\": {\n      \"total\": 1,\n      \"count\": 1,\n      \"per_page\": 15,\n      \"current_page\": 1,\n      \"total_pages\": 1,\n      \"links\": []\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/UserController.php",
    "groupTitle": "user",
    "name": "GetUsers"
  },
  {
    "type": "get",
    "url": "/users/{id}",
    "title": "某个用户信息(some user's info)",
    "description": "<p>某个用户信息(some user's info)</p>",
    "group": "user",
    "permission": [
      {
        "name": "none"
      }
    ],
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"id\": 2,\n    \"email\": \"490554191@qq.com\",\n    \"name\": \"fff\",\n    \"created_at\": \"2015-11-12 10:37:14\",\n    \"updated_at\": \"2015-11-13 02:26:36\",\n    \"deleted_at\": null\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/UserController.php",
    "groupTitle": "user",
    "name": "GetUsersId"
  },
  {
    "type": "patch",
    "url": "/user",
    "title": "修改个人信息(update my info)",
    "description": "<p>修改个人信息(update my info)</p>",
    "group": "user",
    "permission": [
      {
        "name": "JWT"
      }
    ],
    "version": "0.1.0",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "name",
            "description": "<p>name</p>"
          },
          {
            "group": "Parameter",
            "type": "Url",
            "optional": true,
            "field": "avatar",
            "description": "<p>avatar</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"id\": 2,\n   \"email\": 'liyu01989@gmail.com',\n   \"name\": \"ffff\",\n   \"created_at\": \"2015-10-28 07:30:56\",\n   \"updated_at\": \"2015-10-28 09:42:43\",\n   \"deleted_at\": null,\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/UserController.php",
    "groupTitle": "user",
    "name": "PatchUser"
  },
  {
    "type": "post",
    "url": "/users",
    "title": "创建一个用户(create a user)",
    "description": "<p>创建一个用户(create a user)</p>",
    "group": "user",
    "permission": [
      {
        "name": "none"
      }
    ],
    "version": "0.1.0",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Email",
            "optional": false,
            "field": "email",
            "description": "<p>email[unique]</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>password</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL21vYmlsZS5kZWZhcmEuY29tXC9hdXRoXC90b2tlbiIsImlhdCI6IjE0NDU0MjY0MTAiLCJleHAiOiIxNDQ1NjQyNDIxIiwibmJmIjoiMTQ0NTQyNjQyMSIsImp0aSI6Ijk3OTRjMTljYTk1NTdkNDQyYzBiMzk0ZjI2N2QzMTMxIn0.9UPMTxo3_PudxTWldsf4ag0PHq1rK8yO9e5vqdwRZLY\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"email\": [\n        \"该邮箱已被他人注册\"\n    ],\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/UserController.php",
    "groupTitle": "user",
    "name": "PostUsers"
  },
  {
    "type": "put",
    "url": "/user/password",
    "title": "修改密码(edit password)",
    "description": "<p>修改密码(edit password)</p>",
    "group": "user",
    "permission": [
      {
        "name": "JWT"
      }
    ],
    "version": "0.1.0",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "old_password",
            "description": "<p>旧密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>新密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password_confirmation",
            "description": "<p>确认新密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 No Content",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"password\": [\n        \"两次输入的密码不一致\",\n        \"新旧密码不能相同\"\n    ],\n    \"password_confirmation\": [\n        \"两次输入的密码不一致\"\n    ],\n    \"old_password\": [\n        \"密码错误\"\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/V1/UserController.php",
    "groupTitle": "user",
    "name": "PutUserPassword"
  }
] });
