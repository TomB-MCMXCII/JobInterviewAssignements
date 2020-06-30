using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using RedditApi.Request.Models;
using RedditApi.Request.Models.DTOs;
using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Net;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace RedditApi.Request
{
    public class ThreadsService : IThreadsService
    {
        private IRedditClient _redditClient;
        private List<Thread> threads { get; set; }
        private List<ThreadDto> threadDtos { get; set; }
        private Token token { get; set; }

        public ThreadsService(IRedditClient redditClient)
        {
            _redditClient = redditClient;
            threadDtos = new List<ThreadDto>();
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
        public ThreadsDto GetThreadDtos()
        {
            GetBestThreads().Wait();
            GetThreadComments(threads).Wait();

            return new ThreadsDto()
            {
                threads = threadDtos
            };
        }
        public async Task GetBestThreads()
        {
           GetToken();
           threads =  ParseJsonToThreads(await _redditClient.GetBestThreads(token,5));        
        } 
        public async Task GetThreadComments(List<Thread> threads)
        {
            foreach (var thread in threads)
            {
                var commentList = ParseJsonToCommentString(await _redditClient.GetThreadComments(thread,token,8));
                CreateThreadDto(thread,commentList);
            }
        }
        public void CreateThreadDto(Thread thread,List<string> comments)
        {
            var threadDto = new ThreadDto();
            threadDto.title = thread.title;
            threadDto.comments = comments;

            threadDtos.Add(threadDto);

        }
        public List<Thread> ParseJsonToThreads(string responseString)
        {
            var parsedThreads = new List<Thread>();

            for (int i = 0; i < 5; i++)
            {
                var dataNode = JObject.Parse(responseString).SelectToken($"data.children[{i}].data").ToString();
                var thread = JsonConvert.DeserializeObject<Thread>(dataNode);

                parsedThreads.Add(thread);
            }

            return parsedThreads;
        }

        public List<string> ParseJsonToCommentString(string responseString)
        {
            var parsedComments = new List<string>();

            for (int i = 0; i < 5; i++)
            {
                
                var dataNode = JObject.Parse(JArray.Parse(responseString).Last.ToString()).SelectToken($"data.children[{i}].data.body").ToString();
                var thread = dataNode;

                parsedComments.Add(thread);
            }

            return parsedComments;
        }
    }
}
