using RedditApi.Request.Models;
using System.Threading.Tasks;

namespace RedditApi.Request
{
    public interface IRedditClientService
    {
        Task GetBestThreads();
        void GetToken();
        void GetThreadComments();
    }
}