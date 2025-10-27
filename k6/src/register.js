import http from 'k6/http';

export default function registerUser(userId){
    const payload = {
        'email': `karina${userId}@gmail.com`,
        'name' : `karina${userId}`,
        'password': 'rahasia'
    }

    const res = http.post('http://host.docker.internal:8000/api/v1/register', JSON.stringify(payload),{
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
      }
    })

    return res
}