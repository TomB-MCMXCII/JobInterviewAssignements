using RedditApi.Request.Models;
using System.Threading.Tasks;

namespace RedditApi.Request
{
    public interface IRedditRequestService
    {
        Task GetBestThreads();
        Task GetToken();
        Task GetComments();
    }
}