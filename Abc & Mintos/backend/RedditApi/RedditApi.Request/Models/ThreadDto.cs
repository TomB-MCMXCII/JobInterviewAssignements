using System;
using System.Collections.Generic;
using System.Text;

namespace RedditApi.Request.Models
{
    public class ThreadDto
    {
        public string title { get; set; }
        public string[] comments { get; set; }
    }
}
