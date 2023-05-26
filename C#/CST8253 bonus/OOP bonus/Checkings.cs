using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace OOP_bonus
{
    internal class Checking : Account
    {
        public static double cap = 300.00;
        public DateTime? lastWithdraw { get; private set; } = null;
        public double dailyWithdraw { get; private set; } = 0.00;
        public Checking(string name, double balance) : base(name, balance)
        {

        }

        new public void withdraw(double balance)
        {
            if (lastWithdraw != DateTime.Today) //if it is a new day, reset the withdraw limit
            {
                lastWithdraw = DateTime.Today;
                dailyWithdraw = 0.00;
            }

            if((balance <= this.balance) && ((balance + dailyWithdraw) <= 300.00))// withdraw amount must not exide balance or daily limit
            {
                mutateBalance(this.balance - balance);
                dailyWithdraw += balance;
            }
            else
            {
                Console.WriteLine("cannot withdraw more than accounts current balance/daily withdraw amount");
                throw new Exception();
            }
        }
    }
}
