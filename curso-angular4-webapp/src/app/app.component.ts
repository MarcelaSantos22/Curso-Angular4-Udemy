import { GLOBAL } from './services/global';
import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'Productos Angular 4';
  public header_color: string;

  constructor(){
    this.header_color = GLOBAL.header_color;
  }
}
