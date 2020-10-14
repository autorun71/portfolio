import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';

@Component({
  selector: 'app-user-id-page',
  templateUrl: './user-id-page.component.html',
  styleUrls: ['./user-id-page.component.scss']
})
export class UserIdPageComponent implements OnInit {

  constructor(
      private route: ActivatedRoute
  ) {
    console.log(this.route)
  }

  ngOnInit() {
  }

}
