import request from '@/utils/request'

export function login(data) {
  return request({
    url: '/auth/login',
    method: 'post',
    data
  })
}

export function getInfo(token) {
  return request({
    url: '/auth/me',
    method: 'post',
  })
}

export function logout() {
  return request({
    url: '/auth/logout',
    method: 'post'
  })
}

export function UserList(params) {
  return request({
    url: '/v1/app_user',
    method: 'get',
    params
  })
}
