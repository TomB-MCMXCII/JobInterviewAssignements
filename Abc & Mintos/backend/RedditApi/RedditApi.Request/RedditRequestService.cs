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
        public RedditRequestService(HttpClient client)
        {
            _client = client;
            _client.BaseAddress = new Uri(_baseUrl);
        }

        public async Task<Token> GetToken()
        {
            string grant_type = "client_credentials";
            string client_id = "pjUKPH9q5oI13w";
            string client_secret = "NjqFq-T1F8Ba6gn-9zZta9Od82I";
            var client = new WebClient();

            var basicAuthHeader = Convert.ToBase64String(Encoding.Default.GetBytes(client_id + ":" + client_secret));
            client.Headers[HttpRequestHeader.Authorization] = "Basic " + basicAuthHeader;

            var postData = new NameValueCollection();
            postData.Add("grant_type", grant_type);

            var responseBytes = client.UploadValues(_accessTokenUrl, "POST", postData);
            var responseString = Encoding.Default.GetString(responseBytes);
            var response = JsonConvert.DeserializeObject<dynamic>(responseString);

            var accessToken = response.access_token.ToString();
            return new Token();
        }
        public async void GetBestThreads()
        {
            
        }

        private async void GetTopFiveComments()
        {

        }
    }
}
