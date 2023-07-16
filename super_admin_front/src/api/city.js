import request from '@/utils/request'

export function cityList(params) {
  return request({
    url: '/v1/city',
    method: 'get',
    params
  })
}


export function storeCity(params) {
  return request({
    url: '/v1/city/store',
    method:'POST',
    data:params
  })
}

export function deleteCity(params) {
  return request({
    url: '/v1/city/delete',
    method:'POST',
    data:params
  })
}


