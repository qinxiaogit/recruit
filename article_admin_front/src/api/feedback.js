import request from '@/utils/request'

export function FeedList(params) {
  return request({
    url: '/v1/feed_back',
    method: 'get',
    params
  })
}


export function AuditFeed(params) {
  return request({
    url: '/v1/feed_back/audit',
    method:'POST',
    data:params
  })
}


