using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Text;

namespace RedditApi.Request.Models
{
    public class Token : IDisposable
    {
        [JsonProperty("access_token")]
        public string AccessToken { get; set; }
        [JsonProperty("token_type")]
        public string TokenType { get; set; }
        [JsonProperty("expires_in")]
        public string ExpiresIn { get; set; }
        public DateTime TimeTokenRecieved { get; set; }

        public void Dispose()
        {
            Dispose();
        }

        public bool hasExpired()
        {
            if(TimeTokenRecieved.AddHours(1) < DateTime.Now)
            {
                Dispose();
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
