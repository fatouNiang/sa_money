import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { BehaviorSubject, Observable } from 'rxjs';
import { User } from '../_model/user';
import { environment } from 'src/environments/environment';
import { map } from 'rxjs/operators';
import { JwtHelperService } from '@auth0/angular-jwt';





@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private userSubject: BehaviorSubject<User>;
  public user: Observable<User>
  constructor(
    private router: Router,
    private http: HttpClient
  ) {
    this.userSubject= new BehaviorSubject<User>(JSON.parse(localStorage.getItem('use')));
    this.user= this.userSubject.asObservable();

  }
  public get userValue(): User{
    return this.userSubject.value;
  }

  login(email, password){
    return this.http.post<User>(`${environment.apiUrl}/login`, { email, password})
    .pipe(map((response: any) => {
        localStorage.setItem('token', response.token);
      })
    )
  }


  logout(){
    localStorage.removeItem('user');
    this.userSubject.next(null);
    this.router.navigate(['/login']);
   // this.setEtatConnex(false);

  }

  getToken(){
    const localToken= localStorage.getItem('token');
    if(localToken){
      return localStorage
    }
    return null;
  }

  decodeToken(){

    const helper = new JwtHelperService();
    const token =localStorage.getItem('token') ;
    const decodedToken = helper.decodeToken(token);
    console.log(decodedToken);

      if(decodedToken.roles[0]=="ROLE_ADMINSYSTEM"){

        this.router.navigate(['/tabs/navigate'])
      }

  }

}

