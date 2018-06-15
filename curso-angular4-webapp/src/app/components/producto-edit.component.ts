import { Component } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { Producto } from '../models/producto';
import { ProductoService } from '../services/producto.service';
import { GLOBAL } from './../services/global';

@Component({
  selector: 'producto-edit',
  templateUrl: '../views/producto-add.html',
  providers: [ProductoService]
})

export class ProductoEditComponent  {
  public titulo: string;
  public producto: Producto;
  public filesToUpload;
  public resultUpload;
  public is_edit;

  constructor(
    private _productoService: ProductoService,
    private _route: ActivatedRoute,
    private _router: Router
  ) {
    this.producto = new Producto(1, '', '', 1, '');
    this.titulo = 'Editar Producto';
    this.is_edit = true;
  }

  ngOnInit() {
    console.log( 'Componente producto.edit cargado');
    this.getProducto();
   }

  getProducto() {
    this._route.params.forEach((params: Params) => {
      const id = params['id'];

      this._productoService.getProducto(id).subscribe(
        response => {
          console.log(response);

          if (response.code === 200) {
            this.producto = response.data;
          } else {
            this._router.navigate(['/productos']);
          }
        },
        error => {
          console.log(error);
        }
      );
    });
  }

  fileChangeEvent(fileInput: any) {
    this.filesToUpload = <Array<File>>fileInput.target.files;
    console.log(this.filesToUpload);
  }

  onSubmit() {
    if (this.filesToUpload && this.filesToUpload.length > 0) {
      this._productoService.makeFileRequest(GLOBAL.url + 'upload-file', [], this.filesToUpload).then((result) => {
        console.log(result);

        this.resultUpload = result;
        this.producto.imagen = this.resultUpload.filename;
        this.updateProducto();

      }, (error) => {
        console.log(error);
      });
    } else {
      this.updateProducto();
    }
  }

  updateProducto() {
    this._route.params.forEach((params: Params) => {
      const id = params['id'];

      this._productoService.editProducto(id, this.producto).subscribe(
        response => {
          if (response.code === 200) {
            this._router.navigate(['/producto', id]);
          } else {
            console.log(response);
          }
        },
        error => {
          console.log(error);
        }
      );
  });
  }
}
