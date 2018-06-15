import { Component, Input, Output , EventEmitter} from '@angular/core';

@Component({
  selector: "componente-hijo",
  template: `
  <p>Este es el {{title}}</p>
  <ul>
    <li>{{propiedad_uno}}</li>
    <li>{{propiedad_dos.web}}</li>
  </ul>

  <button (click)="enviar()">Enviar datos al padre</button>
  `
})
export class HijoComponent {
  public title: string;

  // @Input(): decorador para poder pasar propiedades desde un componente padre a un componente hijo
  @Input() propiedad_uno: string;
  @Input("texto") propiedad_dos: string;

  // @Output(): decorador para poder pasar propiedades desde un componente hijo a un componente padre
  // EventEmitter: para emitir datos dentro de un evento
  @Output() desde_el_hijo = new EventEmitter();

  constructor() {
    this.title = "Componente hijo";
  }

  ngOnInit() {
    console.log(this.propiedad_uno);
    console.log(this.propiedad_dos);
  }

  enviar() {
    this.desde_el_hijo.emit({
      nombre: "Marcela Quejada"
    });
  }
}
