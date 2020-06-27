using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using RedditApi.Request.Models;
using RestSharp;
using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Net;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using static RedditApi.Request.Models.Thread;

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
        public async void GetBestThreads()
        {
            var client = _clientFactory.CreateClient();

            client.DefaultRequestHeaders.Add("Authorization", "bearer " + token.AccessToken);
            client.DefaultRequestHeaders.Add("User-Agent", "MyWebApi");
            //_client.BaseAddress = new Uri(_baseUrl);
            var responseMessage = await client.GetAsync("https://oauth.reddit.com/best?limit=5");

            var responseContentTask = responseMessage.Content.ReadAsStringAsync();
            responseContentTask.Wait();

            var responseString = responseContentTask.Result;
            Parse(responseString);
            //var data = JObject.Parse(responseString).SelectToken("data").ToString();

            //var vkUsers = JsonConvert.DeserializeObject<Data>(data);
            //var threads = JsonConvert.DeserializeObject<Rootobject>(responseString).data.children;
            
        }
        public List<Thread> Parse(string responseString)
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
        private async void GetTopFiveComments()
        {

        }

    }
}
