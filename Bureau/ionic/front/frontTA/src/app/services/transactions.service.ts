import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { Transaction } from '../_model/transaction';

@Injectable({
  providedIn: 'root'
})
export class TransactionsService {

  constructor(private http: HttpClient) { }
  
  getTransactions():Observable<any>{
    return this.http.get<Transaction[]>(`${environment.apiUrl}/transactions`)
  }
}
