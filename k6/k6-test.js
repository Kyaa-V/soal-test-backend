import http from 'k6/http';
import { sleep } from 'k6';
import registerUser from './src/register';
import loginUser from './src/login';

export const options = {
  scenarios: {
    exec : 'user',
    executor: 'constant-vus',
    vus: 1000,
    durastion : '60s'
  }
}

export function user(){
  const userId = (__VU % 999) + 1

  const register = registerUser(userId)

  const login = loginUser($userId)

  console.log(login.token)

  
}

