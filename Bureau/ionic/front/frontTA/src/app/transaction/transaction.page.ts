import { Component, OnInit } from '@angular/core';
import { TransactionsService } from '../services/transactions.service';
import { Transaction } from '../_model/transaction';

@Component({
  selector: 'app-transaction',
  templateUrl: './transaction.page.html',
  styleUrls: ['./transaction.page.scss'],
})
export class TransactionPage implements OnInit {
  transactions: Transaction[]=[];

  constructor( private transactionService: TransactionsService) { }

  segmentChang="MesTransactions";

  ngOnInit() {
    this.getTransaction()
  }

  getTransaction(){
    this.transactionService.getTransactions().
    subscribe(data=>{
      console.log(data);
      this.transactions=data
    })
  }

  segmentChanged(ev: any) {
    console.log('Segment changed', ev);
  }

}
