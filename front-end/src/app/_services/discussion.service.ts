import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Discussion } from "../discussion/discussion.model";

@Injectable({
  providedIn: 'root'
})
export class DiscussionService {

  constructor(
    private http: HttpClient,
  ) {
  }
  readonly baseURL = 'http://localhost:3000/api';

  getAll() {
      return this.http.get(this.baseURL + `/getDiscussions`);
  }

  createDiscussion(discussion: Discussion) {
    console.log(discussion);
    return this.http.post(this.baseURL + `/add`, discussion);
  }

}
