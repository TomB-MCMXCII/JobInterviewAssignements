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
        public bool isExpired { get; set; }

        public void Dispose()
        {
            Dispose();
        }

        public void hasExpired()
        {
            if(TimeTokenRecieved.AddHours(1) < DateTime.Now)
            {
                isExpired = true;
                Dispose();
            }
        }
    }
}
