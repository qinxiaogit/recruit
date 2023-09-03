import request from '@/utils/request'

export function login(data) {
  return request({
    url: '/auth/backend/login',
    method: 'post',
    data
  })
}

export function getInfo(token) {
  return request({
    url: '/auth/backend/me',
    method: 'post',
  })
}

export function logout() {
  return request({
    url: '/auth/backend/logout',
    method: 'post'
  })
}

/**
 * @desc 用户列表
 * @param params
 * @returns {AxiosPromise}
 * @constructor
 */
export function UserList(params) {
  return request({
    url: '/v1/backend/user/list',
    method: 'get',
    params: params,
  })
}

/**
 * @desc 保存用户信息
 * @returns {AxiosPromise}
 * @constructor
 */
export function SaveUser(data) {
  return request({
    url: '/v1/backend/user/save',
    method: 'post',
    data: data,
  })
}

//删除店铺信息
export function UserDelete(data) {
  return request({
    url: '/v1/backend/user/delete',
    method: 'post',
    data: data,
  })
}


/**
 * 获取用户信息
 * @param data
 * @returns {AxiosPromise}
 * @constructor
 */
export function UserShow(data) {
  return request({
    url: '/v1/backend/user/show',
    method: 'get',
    params: data,
  })
}


export function DashboashAgent(params) {
  return request({
    url: '/v1/backend/jobs/dashboash',
    method: 'post',
    data:params
  })
}
