import { Component } from '@angular/core';
import { Router, ActivatedRoute, Params} from '@angular/router';
import { ProductoService } from '../services/producto.service';
import { Producto } from '../models/producto';

@Component({
  selector: 'productos-list',
  templateUrl: '../views/productos-list.html',
  providers: [ProductoService]
})
export class ProductosListComponent {
  public titulo: string;
  public productos: Producto[];

  constructor(
    private _route: ActivatedRoute,
    private _router: Router,
    private _productoService: ProductoService
  ) {
    this.titulo = 'Listado de Productos';
  }

  ngOnInit() {
    console.log('Se ha cargado el componente productos-list');

    this._productoService.getProductos().subscribe(
      result => {

       if (result.code !== 200) {
         console.log(result);
       }else{
         console.log(result.data);
         this.productos = result.data;
       }
      },
      error => {
        console.log(<any>error);
      }
    );
  }
}
