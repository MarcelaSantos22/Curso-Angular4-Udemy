import { Component } from '@angular/core';
import { Router, ActivatedRoute, Params} from '@angular/router';
import { ProductoService } from '../services/producto.service';

@Component({
  selector: 'productos-list',
  templateUrl: '../views/productos-list.html',
  providers: [ProductoService]
})
export class ProductosListComponent {
  public titulo: string;

  constructor(
    private _route: ActivatedRoute,
    private _router: Router,
    private _productoService: ProductoService
  ) {
    this.titulo = 'Listado de Productos';
  }

  ngOnInit() {
    console.log('Se ha cargado el componente productos-list');

    alert(this._productoService.getProductos());
  }
}
