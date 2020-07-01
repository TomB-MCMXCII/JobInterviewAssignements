using Newtonsoft.Json;
using RedditApi.Request.Models;
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace RedditApi.Request
{
    public class RedditClient : IRedditClient
    {
        private IHttpClientFactory _httpClientFactory { get; set; }
        private string _baseUrl = "https://oauth.reddit.com";
        private string _accessTokenUrl = "https://www.reddit.com/api/v1/access_token";
        readonly string grantType = "client_credentials";
        readonly string clientId = "pjUKPH9q5oI13w";
        readonly string clientSecret = "NjqFq-T1F8Ba6gn-9zZta9Od82I";
        public RedditClient(IHttpClientFactory httpClientFactory)
        {
            _httpClientFactory = httpClientFactory;
        }

        public async Task<Token> GetToken()
        {
            var client = _httpClientFactory.CreateClient();
            var basicAuthHeader = Convert.ToBase64String(Encoding.Default.GetBytes(clientId + ":" + clientSecret));
            client.DefaultRequestHeaders.Add("Authorization", "Basic " + basicAuthHeader);

            var postData = new List<KeyValuePair<string, string>>();
            postData.Add(new KeyValuePair<string, string>("grant_type", grantType));

            FormUrlEncodedContent content = new FormUrlEncodedContent(postData);

            var responseMessage = await client.PostAsync(_accessTokenUrl, content);
            var responseContentTask = responseMessage.Content.ReadAsStringAsync();
            responseContentTask.Wait();

            var responseString = responseContentTask.Result;
            var response = JsonConvert.DeserializeObject<Token>(responseString);

            return new Token()
            {
                AccessToken = response.AccessToken.ToString(),
                ExpiresIn = response.ExpiresIn.ToString(),
                TokenType = response.TokenType.ToString(),
                TimeTokenRecieved = DateTime.Now
            };
        }

        public async Task<string> GetBestThreads(Token token,int count)
        {
            var client = _httpClientFactory.CreateClient();

            client.DefaultRequestHeaders.Add("Authorization", "bearer " + token.AccessToken);
            client.DefaultRequestHeaders.Add("User-Agent", "MyWebApi");

            var responseMessage = await client.GetAsync($"https://oauth.reddit.com/best?limit={count}");

            var responseContentTask = responseMessage.Content.ReadAsStringAsync();
            responseContentTask.Wait();

            return responseContentTask.Result;
            
        }

        public async Task<string> GetThreadComments(Thread thread,Token token,int count)
        {
            var parsedComments = new List<string>();
            var client = _httpClientFactory.CreateClient();
            client.DefaultRequestHeaders.Add("Authorization", "bearer " + token.AccessToken);
            client.DefaultRequestHeaders.Add("User-Agent", "MyWebApi");

            var responseMessage = await client.GetAsync($"https://oauth.reddit.com/r/{thread.subreddit}/comments/{thread.id}?limit={count}");

            var responseContentTask = responseMessage.Content.ReadAsStringAsync();
            responseContentTask.Wait();

            return responseContentTask.Result;

        }
    }
}
