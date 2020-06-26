using RedditApi.Request.Models;
using System.Threading.Tasks;

namespace RedditApi.Request
{
    public interface IRedditRequestService
    {
        void GetBestThreads();
        Task<Token> GetToken();
    }
}