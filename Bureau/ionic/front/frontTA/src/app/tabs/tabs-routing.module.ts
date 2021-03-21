import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabsPage } from './tabs.page';

const routes: Routes = [
  {
    path: '',
    component: TabsPage,
    children: [
      {
        path: 'navigate',
        children:[
          { path:"",
          loadChildren: () => import('../navigate/navigate.module').then( m => m.NavigatePageModule)
        },
        ]
      },
      {
        path: 'transaction',
          children:[
            { path:"",
              loadChildren: () => import('../transaction/transaction.module').then( m => m.TransactionPageModule)
            },
          ],
      },
      {
        path: 'calculatrice',
        children:[
          { path:"",
          loadChildren: () => import('../calculatrice/calculatrice.module').then( m => m.CalculatricePageModule)
        },
        ],
      },
      {
        path: 'commission',
        children:[
          { path:"",
          loadChildren: () => import('../commission/commission.module').then( m => m.CommissionPageModule)
        },
        ],
      }
    ]
  }
];


@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabsPageRoutingModule {}
