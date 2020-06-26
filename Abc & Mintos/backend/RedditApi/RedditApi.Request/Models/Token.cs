using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Text;

namespace RedditApi.Request.Models
{
    public class Token
    {
        [JsonProperty("access_token")]
        string AccessToken { get; set; }
        [JsonProperty("token_type")]
        string TokenType { get; set; }
        [JsonProperty("expires_in")]
        string ExpiresIn { get; set; }
    }
}
