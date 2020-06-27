using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using RedditApi.Request.Models;
using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Net;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace RedditApi.Request
{
    public class RedditRequestService : IRedditRequestService
    {
        private IHttpClientFactory _clientFactory;
        private string _baseUrl = "https://oauth.reddit.com";
        private string _accessTokenUrl = "https://www.reddit.com/api/v1/access_token";
        readonly string grantType = "client_credentials";
        readonly string clientId = "pjUKPH9q5oI13w";
        readonly string clientSecret = "NjqFq-T1F8Ba6gn-9zZta9Od82I";
        private List<Thread> threads { get; set; }
        private Token token { get; set; }

        public RedditRequestService(IHttpClientFactory clientFactory)
        {
            _clientFactory = clientFactory; 
        }

        public async Task GetToken()
        {
            //if (token.hasExpired())
            //{
            var client = _clientFactory.CreateClient();
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

                token = new Token()
                {
                    AccessToken = response.AccessToken.ToString(),
                    ExpiresIn = response.ExpiresIn.ToString(),
                    TokenType = response.TokenType.ToString(),
                    TimeTokenRecieved = DateTime.Now
                };
            //}
        }
        public async Task GetBestThreads()
        {
            var client = _clientFactory.CreateClient();

            client.DefaultRequestHeaders.Add("Authorization", "bearer " + token.AccessToken);
            client.DefaultRequestHeaders.Add("User-Agent", "MyWebApi");

            var responseMessage = await client.GetAsync("https://oauth.reddit.com/best?limit=5");

            var responseContentTask = responseMessage.Content.ReadAsStringAsync();
            responseContentTask.Wait();

            var responseString = responseContentTask.Result;
            threads = ParseJsonToThreads(responseString);
            
        } 
        public List<Thread> ParseJsonToThreads(string responseString)
        {
            var parsedThreads = new List<Thread>();

            for(int i = 0; i < 5; i++)
            {
                var dataNode = JObject.Parse(responseString).SelectToken($"data.children[{i}].data").ToString();
                var thread = JsonConvert.DeserializeObject<Thread>(dataNode);

                parsedThreads.Add(thread);
            }

            return parsedThreads;
        }
        public async Task GetComments()
        {
            var parsedComments = new List<Comment>();
            var client = _clientFactory.CreateClient();
            client.DefaultRequestHeaders.Add("Authorization", "bearer " + token.AccessToken);
            client.DefaultRequestHeaders.Add("User-Agent", "MyWebApi");

            var responseMessage = await client.GetAsync($"https://oauth.reddit.com/r/{threads[0].subreddit}/comments/{threads[0].id}");

            var responseContentTask = responseMessage.Content.ReadAsStringAsync();
            responseContentTask.Wait();

            var responseString = responseContentTask.Result;
        }

    }
}
