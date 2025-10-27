import http from 'k6/http';

export default function createVendor(userId){
    const res = http.post('http://host.docker.internal:8000/api/vendor/create-vendor',
        JSON.stringify({id: userId}), {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    })

    return res
}