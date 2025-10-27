import http from 'k6/http'

export default function getAllVendor(){
    const res = http.get('http://docker.host.internal:8000/api/v1/vendor/get-all-vendors')

    return res
}