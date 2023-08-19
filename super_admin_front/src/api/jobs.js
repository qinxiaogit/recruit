import request from '@/utils/request'

export function JobList(params) {
  return request({
    url: '/v1/jobs',
    method: 'get',
    params
  })
}


export function UpdateJob(id,params) {
  return request({
    url: '/v1/jobs/'+id,
    method: 'put',
    params
  })
}


export function shareJob(params) {
  return request({
    url: '/v1/jobs/share',
    method: 'post',
    data:params
  })
}


