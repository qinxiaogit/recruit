import request from '@/utils/request'

/**
 * 保存banner
 * @param data
 * @returns {AxiosPromise}
 * @constructor
 */
export function BannerSave(data) {
  return request({
    url: '/v1/backend/conf/saveArr',
    method: 'post',
    data: data,
  })
}

export function BannerShow(data) {
  return request({
    url: '/v1/backend/conf/show',
    method: 'get',
    params: data,
  })
}

export function BannerDelete(data) {
  return request({
    url: '/v1/backend/conf/deleteOne',
    method: 'post',
    params: data,
  })
}
