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
    public class RedditClientService : IRedditClientService
    {
        private IRedditClient _redditClient;
        private List<Thread> threads { get; set; }
        private List<ThreadDto> threadDtos { get; set; }
        private Token token { get; set; }

        public RedditClientService(IRedditClient redditClient)
        {
            _redditClient = redditClient;
        }

        public void  GetToken()
        {
            if (token == null)
            {
                token = _redditClient.GetToken().Result;
            }
            else if(token.hasExpired())
            {
                token = _redditClient.GetToken().Result;
            }
        }

        public async Task GetBestThreads()
        {
           GetToken();
           threads =  ParseJsonToThreads(await _redditClient.GetBestThreads(token,5));        
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

        public void GetThreadComments()
        {
            foreach (var thread in threads)
            {
                _redditClient.GetThreadComments(thread,token);
            }
        }

        public void CreateThreadDto(Thread thread,List<string> comments)
        {
            var threadDto = new ThreadDto();
            threadDto.title = thread.title;
            threadDto.comments = comments;

            threadDtos.Add( threadDto);
        }

    }
}
