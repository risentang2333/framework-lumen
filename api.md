## 权限接口文档
## 1.验证访问令牌/权限中间件
当错误码为"10001"时，需请求`admin/changeToken`刷新token
```
{
    "code":"10001",
    "message":"访问令牌已过期",
    "data":[]
}
```
当错误码为“10002”时，需注销重新登录
```
{
    "code":"10002",
    "message":"访问令牌错误",
    "data":[]
}
```
## 2.管理员登录

访问地址： `admin/login`

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
错误提示

```
{
    "code":"1",
    "message":"请输入密码",
    "data":[]
}
```
| 参数名        | 类型   | 说明       |
| ------------- | ------ | ---------- |
| id            | int    | 管理员id   |
| account       | string | 状态码     |
| name          | string | 提示信息   |
| access_token  | string | 访问令牌   |
| refresh_token | string | 刷新令牌   |
| expire        | string | 过期时间戳 |

## 3.刷新访问令牌

访问地址： `admin/changeToken`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| refresh_token | string | 必填 | 刷新令牌 |

成功提示
```
{
    "code":0,
    "message":"刷新令牌成功",
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
错误提示

```
{
    "code":"1",
    "message":"请传入刷新令牌",
    "data":[]
}
```
| 参数名        | 类型   | 说明       |
| ------------- | ------ | ---------- |
| id            | int    | 管理员id   |
| account       | string | 账号       |
| name          | string | 名字       |
| access_token  | string | 访问令牌   |
| refresh_token | string | 刷新令牌   |
| expire        | int    | 过期时间戳 |

## 4.获取菜单

访问地址： `admin/permission/getMenu`

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
            "route": "admin/permission/getManagerList",
            "parent_id": 0,
            "son": [
                {
                    "id": 5,
                    "name": "接口-获取管理员角色信息",
                    "route": "admin/permission/getManagerRole",
                    "parent_id": 4,
                    "son": [
                        {
                            "id": 6,
                            "name": "接口-绑定管理员角色",
                            "route": "admin/permission/editManagerRole",
                            "parent_id": 5
                        },
                        {
                            "id": 7,
                            "name": "接口-获取管理员信息",
                            "route": "admin/permission/getManager",
                            "parent_id": 5
                        }
                    ]
                },
                {
                    "id": 8,
                    "name": "接口-编辑管理员信息",
                    "route": "admin/permission/editManager",
                    "parent_id": 4
                }
            ]
        },
        {
            "id": 9,
            "name": "接口-删除管理员信息",
            "route": "admin/permission/deleteManager",
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
| id | int    | 权限id |
| name | string | 权限名 |
| route     | string | 路由   |
| parent_id | int    | 父级id |

## 5.获取管理员列表

访问地址： `admin/permission/getManagerList`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| 无 | 无 | 无 | 无 |

成功提示
```
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "account": "admin",
            "password": "f973988be6cba09855f84c34d10e8a62",
            "name": "超级管理员",
            "access_token": "07878a2fd2eaedb29ee6eb72a33f3459",
            "refresh_token": "b5956788c30bdf01a1fdc9368729d822",
            "expire": 1547428998,
            "is_administrator": 1
        }
    ],
    "first_page_url": "http://10.0.0.33:1017/admin/permission/getManagerList?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://10.0.0.33:1017/admin/permission/getManagerList?page=1",
    "next_page_url": null,
    "path": "http://10.0.0.33:1017/admin/permission/getManagerList",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
## 6.获取管理员角色绑定信息

访问地址： `admin/permission/getManagerRole`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 管理员id |

成功提示
```
{
    "code": "0",
    "message": "success",
    "data": {
    "roleIds": [
            1
        ],
        "roleList": [
            {
                "id": 1,
                "name": "超级管理员",
                "is_administrator": 1
            }
        ]
    }
}
```
错误提示
```
{
    "code": "1",
    "message": "超级管理员不可修改",
    "data": []
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | ------- |
| roleIds | array | 管理员绑定的角色id |
| roleList | array | 所有角色列表 |

## 7.分配绑定管理员角色

访问地址： `admin/permission/editManagerRole`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 角色id |
| roleIds | array | 必填 | 角色id数组 |

成功提示
```
{
    "code":"0",
    "message":"编辑成功",
    "data":[]
}
```
错误提示
```
{
    "state": "1",
    "message": "超级管理员不可修改",
    "data": []
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| code | int | 状态码 |
| message | string | 提示信息 |
| data | array | 数据 |

## 8.获取管理员信息

访问地址： `admin/permission/getManager`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 管理员id |

成功提示
```
{
    "code": "0",
    "message": "success",
    "data": {
        "id": 1,
        "name": "超级管理员",
        "is_administrator": 1
    }
}
```
错误提示
```
{
    "code": "1",
    "message": "管理员不存在",
    "data": []
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| id   | int | 管理员id   |
| name | string | 管理员名 |
| is_administrator | int | 是否为超管(不用显示) |

## 9.编辑管理员信息

访问地址： `admin/permission/editManager`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 管理员id |
| name | string | 必填 | 角色名 |
| account | string | 必填 | 角色账号 |
| password | string | 必填 | 密码 |
| repassword | string | 必填 | 确认密码 |

成功提示
```
{
    "code": "0",
    "message": "编辑成功",
    "data": []
}
```
错误提示
```
{
    "code": "1",
    "message": "管理员不存在",
    "data": []
}
```
## 10.物理删除管理员

访问地址： `admin/permission/deleteManager`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 管理员id |

成功提示
```
{
    "code": "0",
    "message": "删除成功",
    "data": []
}
```
错误提示
```
{
    "code": "1",
    "message": "管理员不存在",
    "data": []
}
```
## 11.获取角色列表

访问地址： `admin/permission/getRoleList`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| 无 | 无 | 无 | 无 |

成功提示
```
{
    "code": "0",
    "message": "success",
    "data": {
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "超级管理员",
            "is_administrator": 1
        }
    ],
        "first_page_url": "http://10.0.0.33:1017/admin/permission/getRoleList?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://10.0.0.33:1017/admin/permission/getRoleList?page=1",
        "next_page_url": null,
        "path": "http://10.0.0.33:1017/admin/permission/getRoleList",
        "per_page": 20,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```
## 12.获取角色信息

访问地址： `admin/permission/getRole`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 角色id |

成功提示
```
{
    "code": "0",
    "message": "获取成功",
    "data": {
        "id": 1,
        "name": "超级管理员",
        "is_administrator": 1
    }
}
```
错误提示
```
{
    "code": "1",
    "message": "角色不存在",
    "data": []
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| id   | int | 角色id   |
| name | string | 角色名 |
| is_administrator | int | 是否为超管(不用显示) |

## 13.获取角色信息

访问地址： `admin/permission/editRole`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 角色id |
| name | string | 必填 | 角色名 |

成功提示
```
{
    "code": "0",
    "message": "编辑成功",
    "data": []
}
```
错误提示
```
{
    "code": "1",
    "message": "角色不存在",
    "data": []
}
```
## 14.物理删除角色

访问地址： `admin/permission/deleteRole`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 角色id |

成功提示
```
{
    "code": "0",
    "message": "删除成功",
    "data": []
}
```
错误提示
```
{
    "code": "1",
    "message": "角色不存在",
    "data": []
}
```
## 15.获取角色权限信息

访问地址： `admin/permission/getRolePermission`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 角色id |

成功提示
```
{
    "code": "0",
    "message": "success",
    "data": {
        "rolePermissionIds": [
            1,
            2,
            3
        ],
        "permissionList": [
            {
                "id": 1,
                "route": "admin/login",
                "name": "接口-管理员登录"
            },
            {
                "id": 2,
                "route": "admin/changeToken",
                "name": "接口-更新token"
            },
            {
                "id": 3,
                "route": "admin/permission/getMenu",
                "name": "接口-获取菜单"
            }
        ]
    }
}
```
错误提示
```
{
    "code": "1",
    "message": "管理员不存在",
    "data": []
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| id   | int | 权限id |
| rolePermissionIds | array | 角色权限绑定id |
| route | string | 路由 |
| name | int | 权限名字 |

## 16.编辑角色权限信息

访问地址： `admin/permission/editRolePermission`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 角色id |
| permissionIds | array | 必填 | 角色绑定权限id组 |

成功提示
```
{
    "code": "0",
    "message": "编辑成功",
    "data": []
}
```
错误提示
```
{
    "code": "1",
    "message": "管理员不存在",
    "data": []
}
```

## 17.获取权限列表

访问地址： `admin/permission/getPermissionList`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| 无 | 无 | 无 | 无 |

成功提示
```
{
"code": "0",
"message": "success",
"data": {
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "route": "admin/login",
            "name": "接口-管理员登录",
            "description": "",
            "icon": "",
            "sort_order": 0,
            "parent_id": 0,
            "is_api": 0,
            "is_display": 0,
            "is_administrator": 0
        },
        {
            "id": 2,
            "route": "admin/changeToken",
            "name": "接口-更新token",
            "description": "",
            "icon": "",
            "sort_order": 0,
            "parent_id": 0,
            "is_api": 0,
            "is_display": 0,
            "is_administrator": 0
        },
        {
            "id": 3,
            "route": "admin/permission/getMenu",
            "name": "接口-获取菜单",
            "description": "",
            "icon": "",
            "sort_order": 0,
            "parent_id": 0,
            "is_api": 0,
            "is_display": 0,
            "is_administrator": 1
        }
    ]
    "first_page_url": "http://10.0.0.33:1017/admin/permission/getPermissionList?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://10.0.0.33:1017/admin/permission/getPermissionList?page=1",
    "next_page_url": null,
    "path": "http://10.0.0.33:1017/admin/permission/getPermissionList",
    "per_page": 20,
    "prev_page_url": null,
    "to": 20,
    "total": 20
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| id   | int | 权限id |
| route | string | 路由 |
| name | int | 权限名字 |
| description | int | 权限描述 |
| icon | int | 权限图标 |
| sort_order | int | 权限排序顺序 |
| parent_id | int | 权限父级id |
| is_api | int | 是否为api路由 |
| is_display | int | 是否展示 |
| is_administrator | int | 是否为管理员权限 |

## 18.获取权限信息

访问地址： `admin/permission/getPermission`

请求方式：`GET`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 不必填 | 权限id |

成功提示
```
{
    "code": "0",
    "message": "success",
    "data": {
        "method": "edit",
        "permission": {
            "id": 1,
            "route": "admin/login",
            "name": "接口-管理员登录",
            "description": "",
            "icon": "",
            "sort_order": 0,
            "parent_id": 0,
            "is_api": 0,
            "is_display": 0,
            "is_administrator": 0
        },
        "selection": [
            {
            "id": 0,
            "ids": "0",
            "names": "基础"
            },
            {
            "id": 1,
            "ids": "1",
            "names": "接口-管理员登录"
            }
        ]
    }
}
如果不传入id，"method"为"add",permission为空,传入id"method"为"edit"
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| id   | int | 权限id |
| route | string | 路由 |
| name | int | 权限名字 |
| description | int | 权限描述 |
| icon | int | 权限图标 |
| sort_order | int | 权限排序顺序 |
| parent_id | int | 权限父级id |
| is_api | int | 是否为api路由 |
| is_display | int | 是否展示 |
| is_administrator | int | 是否为管理员权限 |

## 19.编辑权限信息

访问地址： `admin/permission/editPermission`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 权限id |
| route | string | 必填 | 权限路由 |
| name | string | 必填 |  权限名字 |
| description | string | 必填 |  权限描述 |
| icon | string | 必填 |  权限图标 |
| sort_order | int | 必填 | 权限排序顺序 |
| parent_id | int | 必填 |  权限父级id |
| is_api | int | 必填 |  是否为api路由 |
| is_display | int | 必填 |  是否展示 |


成功提示
```
{
    "code": "0",
    "message": "编辑成功",
    "data": []
}
```
错误提示
```
{
    "code": "1",
    "message": "请传入权限id",
    "data": []
}
```
| 参数名  | 类型   | 说明     |
| ------- | ------ | -------- |
| id   | int | 权限id |
| route | string | 路由 |
| name | int | 权限名字 |
| description | int | 权限描述 |
| icon | int | 权限图标 |
| sort_order | int | 权限排序顺序 |
| parent_id | int | 权限父级id |
| is_api | int | 是否为api路由 |
| is_display | int | 是否展示 |
| is_administrator | int | 是否为管理员权限 |

## 20.物理删除权限

访问地址： `admin/permission/deleteRole`

请求方式：`POST`

| 参数名 | 类型 | 是否必填 | 说明 |
| ------ | ---- | -------- | ---- |
| id | int | 必填 | 权限id |

成功提示
```
{
    "code": "0",
    "message": "删除成功",
    "data": []
}
```
错误提示
```
{
    "code": "1",
    "message": "请传入权限id",
    "data": []
}
```