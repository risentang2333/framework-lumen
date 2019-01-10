## 权限api
## 1.管理员登录

管理员登录

访问地址： `/admin/login`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| account | string | 必填 | 账号 |
| password | string | 必填 | 密码 |

成功提示
```
{
	"code":0,
	"message":"登录成功",
	"data":{
        "id":1,
        "account":"admin",
        "name":"超级管理员",
        "access_token":"366f0ebce2ea1fdc8a1181b3528436ab",
        "refresh_token":"4f1ccf9399de05e6348ee575b8e77269",
        "expire":1547359240
    }
}
```
失败提示

手机参数为空
```
{
	还没想好
}
```
手机格式错误
```
{
	"state": "10016",
	"message": "mobile is error",
	"data": {}
}
```
验证码还有效，不可重复获取
```
{
	"state": "10022",
	"message": "captcha is valid",
	"data": {}
}
```
手机号发送短信次数超过5次，不能再发送
```
{
	"state": "10021",
	"message": "sms is over five",
	"data": {}
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| state   | int    | 状态码   |
| message | string | 提示信息 |
| data    | array  | 返回数据 |

## 2.刷新token

申请参加抽奖

访问地址： `/admin/changeToken`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| refresh_token | string | 必填 | 刷新token |

成功提示
```
{
    "code":0,
    "message":"+1s成功",
    "data":{
        "id":1,
        "account":"admin",
        "name":"超级管理员",
        "access_token":"d1fb30dc8cec010e597f8084ce433c50",
        "refresh_token":"5d56b91769b5f76ea54c0d7a6cdf1a62",
        "expire":1547360796
    }
}
```
失败提示

暂时没有抽奖活动
```
{
    没想好
}
```
手机号不能为空
```
{
	"state":"10015",
	"message":"mobile is null",
	"data":{}
}
```
手机号格式错误
```
{
	"state":"10016",
	"message":"mobile is error",
	"data":{}
}
```
手机号已参加活动
```
{
	"state":"10017",
	"message":"mobile is exist",
	"data":{}
}
```
验证码已过期
```
{
	"state":"10019",
	"message":"captcha is expired",
	"data":{}
}
```
验证码不同,校验失败
```
{
	"state":"10020",
	"message":"mobile is different",
	"data":{}
}
```
验证码不能为空
```
{
	"state":"10023",
	"message":"captcha is null",
	"data":{}
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| state   | int    | 状态码   |
| message | string | 提示信息 |
| data    | array  | 返回数据 |

## 3.获取菜单

申请参加抽奖

访问地址： `/admin/permission/getMenu`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| access_token |string|必填|token|

成功提示
```
{
    "code": 0,
    "message": "success",
    "data": [
        {
            "id": 4,
            "name": "接口-获取管理员列表",
            "parent_id": 0,
            "son": [
                {
                    "id": 5,
                    "name": "接口-获取管理员角色信息",
                    "parent_id": 4,
                    "son": [
                        {
                        "id": 6,
                        "name": "接口-绑定管理员角色",
                        "parent_id": 5
                        },
                        {
                        "id": 7,
                        "name": "接口-获取管理员信息",
                        "parent_id": 5
                        }
                    ]
                },
                {
                    "id": 8,
                    "name": "接口-编辑管理员信息",
                    "parent_id": 4
                }
            ]
        },
        {
            "id": 9,
            "name": "接口-删除管理员信息",
            "parent_id": 0
        }
    ]
}
```
无数据时

```
{
	"code": 0,
	"message": "success",
	"data": []
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| state   | int    | 状态码   |
| message | string | 提示信息 |
| data | object | 数据对象 |
| ---- | ---- | ---- |
| date | array  | 活动时间 |
| lottery_id | array | 活动时间数组 |
| sign_up_begin | string | 报名开始时间 |
| sign_up_end | string | 报名结束时间 |
| lottery_begin | string | 活动开始时间 |
| gift | array | 奖品数组 |
| id | int | 奖品id |
| name | string | 奖品名称 |
| count | int | 奖品数量 |
| level | int | 奖品等级 |
| users_amount | int | 参与人数 |
## 4.进入抽奖页获取中奖列表

进入抽奖页获取中奖列表

访问地址： `/api/lottery/info`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| lottery_id | string | 必填 | 抽奖活动id |
| level | int | 必填 | 奖品等级 |

成功提示
```
{
	"state": 0,
	"message": "",
	"data": {
		"rolling_data": [
			{
				"id": 3,
				"name": "tc3",
				"mobile": "17640024662",
				"isReceive": 0
			}
		],
		"users_amount": 7,
		"gift_amount": 3
		"list": [
			{
				"id": 3,
				"name": "tc3",
				"mobile": "17640024662",
				"isReceive": 0
			}
		]
	}
}
```
无数据时

```
{
	"state": 0,
	"message": "",
	"data": {
		"rolling_data": [],
		"users_amount": 7,
		"gift_amount": 3
		"list": []
	}
}
```
错误提示

奖品等级不存在
```
{
	"state": "10025",
	"message": "level is null",
	"data": {}
}
```
抽奖活动id不存在
```
{
	"state": "10024",
	"message": "lottery id is null",
	"data": {}
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| state   | int    | 状态码   |
| message | string | 提示信息 |
| data | object | 数据对象 |
| ---- | ---- | ---- |
| users_amount | int | 参与人数 |
| list | array | 中奖列表 |
| lottery_id | array | 活动时间数组 |
| id | int | 中奖人id(可参照排序，对象数组默认正序) |
| name | string | 中奖人名称 |
| mobile | string | 中奖手机号 |
| isReceive | array | 是否领奖 |
| gift_amount | int | 抽奖次数 |
| rolling_data | int | 滚动数据 |

## 5.抽奖

抽奖

访问地址： `/api/lottery/lottery`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| lottery_id | string | 必填 | 抽奖活动id |
| level | int | 必填 | 奖品等级 |

成功提示
```
{
	"state":0,
	"message":"",
	"data":{
		"id":6,
		"name":"tc6",
		"mobile":"17640024665",
		"isReceive":0
	}
}
```
错误提示

抽奖次数已用完
```
{
	"state":"10026",
	"message":"gift num is null",
	"data":{}
}
```
抽奖人数为空
```
{
	"state":"10027",
	"message":"user is null",
	"data":{}
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| state   | int    | 状态码   |
| message | string | 提示信息 |
| data | object | 数据对象 |
| ---- | ---- | ---- |
| id | int | 中奖人id |
| name | string | 中奖人名称 |
| mobile | string | 中奖手机号 |
| isReceive | array | 是否领奖 |

## 6.抽奖等级列表

抽奖

访问地址： `/api/lottery/list`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| lottery_id | string | 必填 | 抽奖活动id |

成功提示
```
{
    "state": 0,
    "message": "",
    "data": [
        {
            "id": 1,
            "name": "小米手环",
            "count": 1,
            "level": 1
        },
        {
            "id": 2,
            "name": "小米pad",
            "count": 0,
            "level": 2
        },
        {
            "id": 3,
            "name": "小米充电宝",
            "count": 5,
        	"level": 3
        }
    ]
}
```
数据为空
```
{
    "state": 0,
    "message": "",
    "data": []
}
```
错误提示

活动id为空
```
{
    "state": "10024",
    "message": "lottery id is null",
    "data": {}
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| state   | int    | 状态码   |
| message | string | 提示信息 |
| data | object | 数据对象 |
| ---- | ---- | ---- |
| id | int | 奖品id |
| name | string | 奖品名称 |
| count | int | 商品数量(抽奖次数) |
| level | int | 奖品等级 |

## 7.注册页获取开奖时间

注册页获取开奖时间

访问地址： `/api/lottery/getDate`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| 无 | ---- | ---- | ----- |

成功提示
```
{
    "state": 0,
    "message": "",
    "data": {
        "lottery_id": 1,
        "sign_up_begin": 1536768000,
        "sign_up_end": 1538291794,
        "lottery_begin": 1539933399
    }
}
```
数据为空
```
{
    "state": 0,
    "message": "",
    "data": []
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| state   | int    | 状态码   |
| message | string | 提示信息 |
| data | object | 数据对象 |
| lottery_id | array | 活动时间数组 |
| sign_up_begin | string | 报名开始时间 |
| sign_up_end | string | 报名结束时间 |
| lottery_begin | string | 活动开始时间 |