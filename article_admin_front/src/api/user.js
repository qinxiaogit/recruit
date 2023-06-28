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

export function UserList(params) {
  return request({
    url: '/auth/backend/app_user',
    method: 'get',
    params
  })
}
