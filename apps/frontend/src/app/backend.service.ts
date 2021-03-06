import {Injectable} from '@angular/core';
import {HttpClient, HttpParams, HttpRequest} from "@angular/common/http";
// All the RxJS stuff we need
import {Observable, throwError} from 'rxjs';
import {catchError, map} from 'rxjs/operators';
import {environment} from "src/environments/environment";

@Injectable()
export class BackendService {

  private host = environment.host;
  private auth_token = 'api_token_1';

  constructor(
    private http: HttpClient,
  ) {
  }

  request(path: string, method: any = 'GET', bodyParams?: object, queryParams?: HttpParams): Observable<any> {
    const url = this.host + '/' + path;

    let req = null;
    switch (method) {
      case 'GET':
      case 'HEAD':
      case 'DELETE':
      case 'OPTIONS':
        req = new HttpRequest(method, url, {
          params: queryParams,
        });
        break;
      default:
        req = new HttpRequest(method, url, bodyParams, {
          params: queryParams,
        });
    }
    return this.http.request(
      method,
      url,
      {
        body: bodyParams,
        params: queryParams,
        headers: {
          'Authorization': 'Bearer ' + this.auth_token,
        }
      }
    ).pipe(
      map(this.parseData),
      catchError(this.handleError)
    ) as Observable<any>;
  }

  private parseData(res: any) {
    return res;
  }

  // Displays the error message
  private handleError(response: Response | any) {
    if (response.status === 401) {
      console.error('Unauthenticated');
    }

    let errorMessage: string;

    errorMessage = response.error ? response.error : response.toString();

    console.error(typeof errorMessage);
    // In real world application, call to log response to remote server
    // logError(response);

    // This returns another Observable for the observer to subscribe to
    return throwError(errorMessage);
  }
}
