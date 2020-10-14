import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CustomRouterService {

  route = {
    name: null,
    condition: null,
    params: null,
    queryParams: null
  };

  constructor() { }
}
