using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Transactions;

namespace OOP_bonus
{
    internal class Saving:Account
    {
        public static double penalty = 10.00;
        public static double interestRate = 1.03;
        public Saving(string name, double balance) : base(name, balance)
        {

        }
        
        new public void deposit(double balance) //overidden method applies interest on deposit
        {
            mutateBalance(this.balance + (balance * interestRate));
        }

        new public void withdraw(double balance) //overidden method checks if withdraw is more than the balance and adds a penalty
        {
            if ((balance + 10) <= this.balance)
            {
                mutateBalance(this.balance - (balance + 10));
            }
            else
            {
                Console.WriteLine("Withdraw amount cannot exide current balance.");
                throw new Exception();
            }
        }
    }
}
