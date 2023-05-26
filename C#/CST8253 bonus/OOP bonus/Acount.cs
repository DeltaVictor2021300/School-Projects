using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace OOP_bonus
{
    internal class Account
    {
        public double balance { get; private set; }
        public string name { get; }

        public Account(string name, double balance)
        {
            this.name = name;
            this.balance = balance;
        }

        public void deposit(double balance)
        {
            this.balance += balance;
        }

        public void withdraw(double balance)
        {
            if (balance <= this.balance)
            {
                this.balance -= balance;
            }
            else
            {
                Console.WriteLine("Withdraw amount cannot exide the current balance");
                throw new Exception();
            }
            
        }

        public void mutateBalance(double balance)
        {
            this.balance = balance;
        }
    }
}
