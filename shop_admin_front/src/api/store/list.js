import request from '@/utils/request'
import da from "element-ui/src/locale/lang/da";

export function StoreList(data) {
  console.log(data)
  return request({
    url: '/v1/store',
    method: 'post',
    data
  })
}

//审核
export function StoreAudit(data) {
  return request({
    url: '/v1/store/audit',
    method: 'post',
    data
  })
}


//上下架
export function StoreStatus(data) {
  return request({
    url: '/v1/store/status',
    method: 'post',
    data
  })
}

//余额变更
export function StoreBalance(data) {
  return request({
    url: '/v1/store/balance',
    method: 'post',
    data: data
  })
}

//商户详情
export function StoreShow(data) {
  return request({
    url: '/v1/store/show',
    method: 'get',
    data: data
  })
}

export function UpdateStore(id, params) {
  return request({
    url: '/v1/store/' + id,
    method: 'put',
    params
  })
}


