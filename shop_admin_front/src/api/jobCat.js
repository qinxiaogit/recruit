import request from '@/utils/request'

export function JobCateList(params) {
  return request({
    url: '/v1/job_cat',
    method: 'get',
    params
  })
}

export function JobCateALL(params) {
  return request({
    url: '/v1/job_cat/all',
    method: 'get',
    params
  })
}

export function CreateJobCate(params) {
  return request({
    url: '/v1/job_cat',
    method: 'post',
    params
  })
}

export function JobCateTree(params) {
  return request({
    url: '/v1/job_cat/tree',
    method: 'get',
    params
  })
}

export function DeleteJobCate(params) {
  return request({
    url: '/v1/job_cat/delete',
    method: 'POST',
    params,
    data:params
  })
}

export function SelectJobCat(params) {
  return request({
    url: '/v1/job_cat/delete',
    method: 'GET',
    params,
    data:params
  })
}
