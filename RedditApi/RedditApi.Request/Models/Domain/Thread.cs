using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Text;
using System.Text.Json.Serialization;

namespace RedditApi.Request.Models
{
    public class Thread
    {
        public string title { get; set; }
        public string id { get; set; } 
        public string subreddit { get; set; }
    }
}
