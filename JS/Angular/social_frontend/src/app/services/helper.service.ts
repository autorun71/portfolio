import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class HelperService {

  constructor() { }

  timeToStr(time, delimiter = ':', hhh = true, mmm = true): string {
    const h = Math.floor(time / 3600);
    const m = Math.floor((time - h * 3600) / 60);
    const s = Math.floor((time - h * 3600) - m * 60);

    let hh = String(h);
    let mm = String(m);
    let ss = String(s);

    if (hh.length !== 2) {
      hh = '0' + hh;
    }

    if (mm.length !== 2) {
      mm = '0' + mm;
    }

    if (ss.length !== 2) {
      ss = '0' + ss;
    }

    return (hhh ? hh + delimiter : '') + (mmm ? mm + delimiter : '') + ss;
  }
}
