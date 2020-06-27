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
        private IRedditRequestService _redditRequestService;
        public ThreadController(IRedditRequestService redditRequestService)
        {
            _redditRequestService = redditRequestService;
        }
        [HttpGet]
        [Route("api/thread/get")]
        public IActionResult GetBestThreads()
        {
            _redditRequestService.GetToken().Wait();
            _redditRequestService.GetBestThreads();
            return Ok();
        }
    }
}
