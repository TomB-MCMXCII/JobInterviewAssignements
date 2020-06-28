using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using RedditApi.Request;

namespace RedditApi.WebApi.Controllers
{
    
    [ApiController]
    public class ThreadController : ControllerBase
    {
        private IRedditClientService _redditRequestService;
        public ThreadController(IRedditClientService redditRequestService)
        {
            _redditRequestService = redditRequestService;
        }
        [HttpGet]
        [Route("api/thread/get")]
        public IActionResult GetBestThreads()
        {
            _redditRequestService.GetBestThreads().Wait();

            return Ok();
        }
    }
}
