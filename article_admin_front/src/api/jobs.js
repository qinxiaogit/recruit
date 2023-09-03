import request from '@/utils/request'

export function JobList(params) {
  return request({
    url: '/v1/backend/jobs',
    method: 'get',
    params
  })
}


export function UpdateJob(id, params) {
  return request({
    url: '/v1/jobs/' + id,
    method: 'put',
    params
  })
}


export function showJob(id) {
  return request({
    url: '/v1/jobs/' + id,
    method: 'get',
  })
}

export function createOrEditJob(params) {
  return request({
    url: '/v1/jobs/store',
    method: 'post',
    data: params
  })
}

export function EditJob(id,params) {
  return request({
    url: '/v1/jobs/edit/'+id,
    method: 'post',
    data: params
  })
}


export function reportJob(params) {
  return request({
    url: '/v1/jobs/report',
    method: 'POST',
    data: params
  })
}

export function reportStatusJob(params) {
  return request({
    url: '/v1/jobs/report_status',
    method: 'POST',
    data: params
  })
}


export function shareJob(params){
  return request({
    url: '/v1/backend/jobs/share',
    method: 'post',
    data: params
  })
}
