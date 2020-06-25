using System;
using System.Net.Http;

namespace RedditApi.Request
{
    public class RedditRequest
    {
        private RedditHttpClient client { get; set; }
        public RedditRequest()
        {
            client = new RedditHttpClient();
        }
    }
}
