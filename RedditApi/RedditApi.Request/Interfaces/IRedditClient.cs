using RedditApi.Request.Models;
using System.Threading.Tasks;

namespace RedditApi.Request
{
    public interface IRedditClient
    {
        Task<Token> GetToken();
        Task<string> GetBestThreads(Token token,int count);
        Task<string> GetThreadComments(Thread thread,Token token,int count);
    }
}