using Newtonsoft.Json;
using RedditApi.Request.Models;
using RestSharp;
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
        private HttpClient _client;
        private string _baseUrl = "https://oauth.reddit.com";
        private string _accessTokenUrl = "https://www.reddit.com/api/v1/access_token";
        readonly string grantType = "client_credentials";
        readonly string clientId = "pjUKPH9q5oI13w";
        readonly string clientSecret = "NjqFq-T1F8Ba6gn-9zZta9Od82I";

        public RedditRequestService(HttpClient client)
        {
            _client = client;
            _client.BaseAddress = new Uri(_baseUrl);
        }

        public async Task<Token> GetToken()
        {
            var basicAuthHeader = Convert.ToBase64String(Encoding.Default.GetBytes(clientId + ":" + clientSecret));
            _client.DefaultRequestHeaders.Add("Authorization", "Basic " + basicAuthHeader);

            var postData = new List<KeyValuePair<string, string>>();
            postData.Add(new KeyValuePair<string, string>("grant_type", grantType));
            FormUrlEncodedContent content = new FormUrlEncodedContent(postData);


            var responseMessage = await _client.PostAsync(_accessTokenUrl, content);
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
        public async void GetBestThreads(Token token)
        {
            
        }

        private async void GetTopFiveComments()
        {

        }

    }
}
