using RedditApi.Request.Models;
using System.Threading.Tasks;

namespace RedditApi.Request
{
    public interface IRedditClientService
    {
        Task GetBestThreads();
        Task GetToken();
        Task GetThreadComments(Thread thread);
    }
}