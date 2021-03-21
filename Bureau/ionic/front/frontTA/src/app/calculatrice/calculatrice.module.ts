import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CalculatricePageRoutingModule } from './calculatrice-routing.module';

import { CalculatricePage } from './calculatrice.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    CalculatricePageRoutingModule,
    ReactiveFormsModule
  ],
  declarations: [CalculatricePage]
})
export class CalculatricePageModule {}
