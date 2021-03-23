import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class DepotService {
  private headerJson = new HttpHeaders({'Content-type': 'application/json'});
  montant:number;


  constructor(private http: HttpClient) { }

  depot(body: any){
    return this.http.post(`${environment.apiUrl}/transaction/depots`,
        body, { headers : this.headerJson } );
  }

  // getCompte(id: any):any{
  //   return this.http.get(`${environment.apiUrl}/comptes`+ id)
  // }

  getSolde(): Observable<any>{
    return this.http.get<any[]>(`${environment.apiUrl}/users/comptes/curentUser`);
  }

max_array = [5000, 10000, 15000, 20000, 50000,60000,75000,120000,150000,200000,250000,
    300000,400000,750000,900000,1000000,1125000,1400000,2000000];
frai_array = [425, 850, 1270, 1695, 2500, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 12000,
    15000, 22000, 25000, 27000, 30000, 30000];


    calcalueFraisTransfert(montant: number){
      for (let i = 0; i < this.max_array.length; i++){
        if (montant <= this.max_array[i]){
          return this.frai_array[i];
        }
        if (montant > 2000000){
          return montant * 0.2;
        }
      }
    }

//  calculFraisTotal(montant:number){

//    let frais: number;
//     switch (montant) {
//         case 1:
//           if(montant<=5000){
//             return frais = 425;
//           }
//             break;
//         case 2:
//           if(montant<=10000 && montant > 5000){
//             frais = 850;
//           }
//             break;
//         case 3:
//             if(montant<=15000 && montant > 10000)
//               frais = 1270;
//             break;
//         case 4:
//           if(montant<=20000 && montant > 15000)
//             frais = 1695;
//             break;

//         case 5:
//           if(montant<=50000 && montant > 20000)
//            frais =  2500;
//             break;

//         case 6:
//           if(montant<=60000 && montant > 50000)
//            frais =  3000;
//             break;
//         case 7:
//           if(montant<=75000 && montant > 60000)
//            frais =  4000;
//             break;
//         case 8:
//           if(montant<=120000 && montant > 75000)
//            frais =  5000;
//             break;
//         case 9:
//           if(montant<=150000 && montant > 120000)
//            frais =  6000;
//             break;
//         case 10:
//           if (montant<=200000 && montant > 150000)
//            frais =  7000;
//             break;
//         case 11:
//         if (montant<=250000 && montant > 200000)
//            frais =8000;
//             break;
//         case 12:
//           if (montant<=300000 && montant > 250000)
//            frais =  9000;
//             break;
//         case 13:
//           if (montant<=400000 && montant > 300000)
//            frais =  12000;
//             break;
//         case  14:
//           if (montant<=750000 && montant > 400000)
//            frais =  15000;
//             break;
//         case 15:
//           if (montant<=900000 && montant > 750000)
//            frais =  22000;
//             break;
//         case 16:
//           if (montant<=1000000 && montant > 900000)
//            frais =  25000;
//             break;
//          case 17:
//           if (montant<=1125000 && montant > 1000000)
//            frais =  27000;
//             break;
//          case 18:
//           if (montant<=1400000 && montant > 1125000)
//            frais =  30000;
//             break;
//          case 19:
//           if (montant<=2000000 && montant > 1400000)
//            frais =  30000;
//             break;
//         case  20:
//           if (montant > 2000000)
//            frais = (2 * montant)/100;
//             break;
//     }
// }

}
