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
        private IThreadsService _redditRequestService;
        public ThreadController(IThreadsService redditRequestService)
        {
            _redditRequestService = redditRequestService;
        }
        [HttpGet]
        [Route("api/thread/get")]
        public IActionResult GetBestThreads()
        {
            var threadsDto = _redditRequestService.GetThreadDtos();

            return Ok(threadsDto);
        }
    }
}
