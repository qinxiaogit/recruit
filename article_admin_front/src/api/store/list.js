import request from '@/utils/request'
import da from "element-ui/src/locale/lang/da";

export function StoreList(data) {
  return request({
    url: '/v1/backend/store/list',
    method: 'get',
    params: data
  })
}

//修改新增店铺
export function StoreSave(data) {
  return request({
    url: '/v1/backend/store/save',
    method: 'post',
    data: data,
  })
}

//删除店铺信息
export function StoreDelete(data) {
  return request({
    url: '/v1/backend/store/delete',
    method: 'post',
    data: data,
  })
}

//删除店铺信息
export function StoreShow(data) {
  return request({
    url: '/v1/backend/store/show',
    method: 'post',
    data: data,
  })
}
