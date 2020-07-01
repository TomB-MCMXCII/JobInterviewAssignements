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
        private IThreadsService _threadsService;
        public ThreadController(IThreadsService threadsService)
        {
            _threadsService = threadsService;
        }
        [HttpGet]
        [Route("api/thread/get")]
        public IActionResult GetBestThreads()
        {
            var threadsDto = _threadsService.GetThreadDtos();

            return Ok(threadsDto);
        }
    }
}
