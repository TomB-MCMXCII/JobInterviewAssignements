using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Text;

namespace RedditApi.Request
{
    public class RedditHttpClient
    {
        public HttpClient client { get; set; }
        public RedditHttpClient()
        {
            client = new HttpClient();
            client.BaseAddress = new Uri("https://oauth.reddit.com");
        }
        
    }
}
