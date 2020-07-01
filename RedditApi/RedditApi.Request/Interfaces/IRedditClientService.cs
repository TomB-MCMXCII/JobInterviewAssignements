
using RedditApi.Request.Models.DTOs;


namespace RedditApi.Request
{
    public interface IThreadsService
    {
        ThreadsDto GetThreadDtos();
    }
}